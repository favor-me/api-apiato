<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\TelegramSection\Bot\Handlers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\TelegramSection\Bot\Facades\Container;
use App\Containers\TelegramSection\Bot\Foundation\Storage;
use App\Containers\TelegramSection\Bot\Handlers\Actions\Action;
use App\Containers\TelegramSection\Bot\Services\HandleChatMessageService;
use Closure;
use DefStudio\Telegraph\DTO\Message;
use DefStudio\Telegraph\Exceptions\TelegramWebhookException;
use DefStudio\Telegraph\Handlers\WebhookHandler as BaseWebhookHandler;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class WebhookHandler extends BaseWebhookHandler
{
    public const string STORE_START_REMEMBER_PWD = 'start_remember_pwd';

    protected ?Action $handleAction = null;
    protected Storage $storage;

    public function getChat(): TelegraphChat
    {
        return $this->chat;
    }

    public function getStorage(): Storage
    {
        return $this->storage;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function runAction(string $action, ?Closure $beforeHandleCallback = null): void
    {
        if ($this->isHandleAction($action)) {
            $method = $this->getActionMethod($this->handleAction);

            if (!is_null($beforeHandleCallback)) {
                $beforeHandleCallback($this->handleAction);
            }

            $this->handleAction->$method();
        }
    }

    protected function canHandle(string $action): bool
    {
        $canHandle = parent::canHandle($action);

        if (!$canHandle) {
            $canHandle = $this->isHandleAction($action);
        }

        return $canHandle;
    }

    protected function doHandleAction(mixed $parameter): bool
    {
        if (!is_null($this->handleAction)) {
            $method = $this->getActionMethod($this->handleAction);
            $this->handleAction->$method($parameter);
            return true;
        }

        return false;
    }

    protected function getActionMethod(Action $action): string
    {
        return method_exists($action, 'handle') ? 'handle' : '__invoke';
    }

    /**
     * @return void
     * @throws TelegramWebhookException
     */
    protected function handleCallbackQuery(): void
    {
        $this->extractCallbackQueryData();

        if (config('telegraph.debug_mode', config('telegraph.webhook.debug'))) {
            Log::debug('Telegraph webhook callback', $this->data->toArray());
        }

        /** @var string $action */
        $action = $this->callbackQuery?->data()->get('action') ?? '';

        if (!$this->canHandle($action)) {
            report(TelegramWebhookException::invalidAction($action));
            $this->reply(__('telegraph::errors.invalid_action'));
            return;
        }

        if (!$this->doHandleAction($this->data->toArray())) {
            /** @phpstan-ignore-next-line */
            App::call([$this, $action], $this->data->toArray());
        }
    }

    protected function handleCommand(Stringable $text): void
    {
        [$command, $parameter] = $this->parseCommand($text);

        if (!$this->canHandle($command)) {
            $this->handleUnknownCommand($text);
            return;
        }

        if (!$this->doHandleAction($parameter)) {
            $this->$command($parameter);
        }
    }

    protected function isHandleAction(string $action): bool
    {
        $className = $action;
        if (!class_exists($className)) {
            $actionPath = Container::getPath('Handlers/Actions');
            $actionName = Str::ucfirst(Str::camel($action)) . 'Action';
            $actionObjectFile = $actionPath . '/' . $actionName . '.php';

            if (File::exists($actionObjectFile)) {
                $className = Apiato::getClassFullNameFromFile($actionObjectFile);
            }
        }

        if (class_exists($className)) {
            $actionClass = app($className, ['handler' => $this]);
            if (is_subclass_of($actionClass, Action::class)) {
                $this->handleAction = $actionClass;
                return true;
            }
        }

        return false;
    }

    protected function handleChatMessage(Stringable $text): void
    {
        (new HandleChatMessageService($this))
            ->setMessage($text)
            ->run();
    }

    /**
     * @return void
     * @throws FileNotFoundException
     */
    protected function setupChat(): void
    {
        parent::setupChat();
        $this->storage = new Storage($this->chat->chat_id);
    }
}

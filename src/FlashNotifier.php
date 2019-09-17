<?php

namespace Bitgroupasia\Flash;

use Illuminate\Support\Traits\Macroable;

class FlashNotifier
{
    use Macroable;

    /**
     * The session store
     *
     * @var SessionStore
     */
    protected $session;

    /**
     * The messages collection
     *
     * @var \Illuminate\Support\Collection
     */
    public $messages;

    function __construct(SessionStore $session)
    {
        $this->session = $session;
        $this->messages = collect();
    }

    /**
     * Flash an information message.
     *
     * @param string|null $message
     * @return FlashNotifier
     */
    public function info($message = null)
    {
        return $this->message($message, 'info');
    }

    /**
     * Flash an success message.
     *
     * @param string|null $message
     * @return FlashNotifier
     */
    public function success($message = null)
    {
        return $this->message($message, 'success');
    }

    /**
     * Flash an error message.
     *
     * @param string|null $message
     * @return FlashNotifier
     */
    public function error($message = null)
    {
        return $this->message($message, 'danger');
    }

    /**
     * Flash an warning message.
     *
     * @param string|null $message
     * @return FlashNotifier
     */
    public function warning($message = null)
    {
        return $this->message($message, 'warning');
    }

    /**
     * Flash a general message
     *
     * @param string|null $message
     * @param string|null $level
     * @return FlashNotifier
     */
    public function message($message = null, $level = null)
    {
        if (! $message) {
            return $this->updateLastMessage(compact('level'));
        }

        if (! $message instanceof Message) {
            $message = new Message(compact('message', 'level'));
        }

        $this->messages->push($message);


        return $this->flash();
    }

    /**
     * Modify the most recently added message
     *
     * @param array $overrides
     * @return FlashNotifier
     */
    protected function updateLastMessage(array $overrides = [])
    {
        $this->messages->last()->update($overrides);

        return $this;
    }

    /**
     * Flash an overlay modal.
     *
     * @param string|null $message
     * @param string      $title
     * @return FlashNotifier
     */
    public function overlay($messages = null, string $title = 'Notice')
    {
        if (! $message) {
            return $this->updateLastMessage(['title' => $title, 'overlay' => true]);
        }

        return $this->message(
            new OverlayMessage(compact('title', 'message'))
        );
    }

    /**
     * Add an "important" flash to the session.
     *
     * @return FlashNotifier
     */
    public function important()
    {
        return $this->updateLastMessage(['important' => true]);
    }

    /**
     * Clear all registered messages.
     *
     * @return FlashNotifier
     */
    public function clear()
    {
        $this->messages = collect();

        return $this;
    }

    /**
     * Flash all messages to the session
     *
     * @return FlashNotifier
     */
    protected function flash()
    {
        $this->session->flash('flash_notification', $this->messages);

        return $this;
    }
}

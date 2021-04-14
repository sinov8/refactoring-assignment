<?php

class ReturnTest1
{
    /**
     * How can this function be improved to be more readable and efficient
     */
    public function calculateScore(User $user): int
    {
        if ($user->inactive) {
            $score = 0;
        } else {
            if ($user->hasBonus) {
                $score = $user->score + $this->bonus;
            } else {
                $score = $user->score;
            }
        }

        return $score;
    }

}


class ReturnTest2
{
    /**
     * What small simple change can we make here to make this code more readable?
     */
    public function sendInvoice(Invoice $invoice): void
    {
        if ($user->notificationChannel === 'Slack') {
            $this->notifier->slack($invoice);
        } else {
            $this->notifier->email($invoice);
        }
    }
}

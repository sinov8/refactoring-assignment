<?php


class NamingTest1
{

    public function test()
    {
        // How can this statement below be improved ?
        $status = $user->status('pending');
    }

}


class NamingTest2
{

    public function test()
    {
        // What is wrong with this statement below? How can this statement be improved?
        return $factory->getTargetClass();
    }

}


/**
 * How can this class's method parameters be improved
 */
class NamingTest3
{

    public function findUserForInvoice($userId, $InvoiceId)
    {
        //
    }

    public function findUserForQuote($user_id, $invoice_Id)
    {
        //
    }

}



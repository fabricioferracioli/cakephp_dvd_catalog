<?php

    class LoansController extends AppController
    {
        var $name = 'Loans';

        var $helpers = array('Html', 'Form', 'Javascript', 'Ajax');
        var $components = array('RequestHandler');

        function loan_dvd()
        {
            if (!empty($this->data['Loan']['name']))
            {
                if ($this->Loan->save($this->data))
                {
                    $this->Session->setFlash('DVD emprestado com sucesso!', 'default', array('class' => 'success'));
                }
                else
                {
                    $this->Session->setFlash('Não foi possível emprestar o DVD!', 'default', array('class' => 'failure'));
                }
            }
        }

        function return_dvd()
        {
            if (!empty($this->data['Loan']['id']))
            {
                $this->Loan->id = $this->data['Loan']['id'];
                if ($this->Loan->saveField('returned', date('Y-m-d H:i:s')))
                {
                    $this->Session->setFlash('DVD devolvido com sucesso!', 'default', array('class' => 'success'));
                }
                else
                {
                    $this->Session->setFlash('Não foi possível devolver o DVD!', 'default', array('class' => 'failure'));
                }
            }
        }
    }

?>
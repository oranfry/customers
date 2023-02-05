<?php
namespace customers\linetype;

class customerinvoiceline extends \jars\Linetype
{
    public function __construct()
    {
        $this->table = 'customerinvoiceline';

        $this->fields = [
            'num' => function($records) {
                return @$records['/']->num;
            },
            'description' => function($records) {
                return $records['/']->description;
            },
            'moredescription' => function($records) {
                return @$records['/']->moredescription;
            },
            'amount' => function($records) {
                return $records['/']->amount;
            },
        ];

        $this->unfuse_fields = [
            'num' => function($line, $oldline) {
                return @$line->num;
            },
            'description' => function($line, $oldline) {
                return $line->description;
            },
            'moredescription' => function($line, $oldline) {
                return @$line->moredescription;
            },
            'amount' => function($line, $oldline) {
                return $line->amount;
            },
        ];
    }

    public function validate($line)
    {
        $errors = [];

        if (@$line->description == null) {
            $errors[] = 'no description';
        }

        return $errors;
    }
}

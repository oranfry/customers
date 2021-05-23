<?php
namespace customers\linetype;

class customerinvoiceline extends \Linetype
{
    public function __construct()
    {
        $this->label = 'Customer Invoice Line';
        $this->icon = 'docpdf';
        $this->table = 'customerinvoiceline';
        $this->fields = [
            (object) [
                'name' => 'num',
                'type' => 'number',
                'fuse' => '{t}.num',
            ],
            (object) [
                'name' => 'description',
                'type' => 'text',
                'fuse' => '{t}.description',
            ],
            (object) [
                'name' => 'moredescription',
                'type' => 'text',
                'fuse' => '{t}.moredescription',
            ],
            (object) [
                'name' => 'amount',
                'type' => 'number',
                'dp' => 2,
                'summary' => 'sum',
                'fuse' => '{t}.amount',
            ],
        ];
        $this->unfuse_fields = [
            '{t}.num' => (object) [
                'expression' => ':{t}_num',
                'type' => 'integer',
            ],
            '{t}.description' => (object) [
                'expression' => ':{t}_description',
                'type' => 'varchar(255)',
            ],
            '{t}.moredescription' => (object) [
                'expression' => ':{t}_moredescription',
                'type' => 'varchar(255)',
            ],
            '{t}.amount' => (object) [
                'expression' => ':{t}_amount',
                'type' => 'decimal(18, 2)',
            ],
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

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
            '{t}.description' => ':{t}_description',
            '{t}.moredescription' => ':{t}_moredescription',
            '{t}.amount' => ':{t}_amount',
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

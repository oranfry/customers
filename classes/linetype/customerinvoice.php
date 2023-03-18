<?php
namespace customers\linetype;

class customerinvoice extends \jars\Linetype
{
    public function __construct()
    {
        $this->table = 'customerinvoice';

        $this->simple_strings('date', 'email', 'name', 'address', 'description');

        $this->fields['amount'] = fn ($records) : string => bcadd('0', $records['/']->amount ?? '0', 2);
        $this->unfuse_fields['amount'] = fn ($line) : string => $line->amount ?? '0.00';

        $this->fields['broken'] = function($records) {
            if (!@$records['/']->user) {
                return 'no user';
            }
        };

        $this->children = [
            (object) [
                'linetype' => 'customerinvoiceline',
                'property' => 'lines',
                'tablelink' => 'customerinvoice_line',
                'only_parent' => 'customerinvoice_id',
           ],
        ];
    }

    public function validate($line)
    {
        $errors = [];

        if (@$line->date == null) {
            $errors[] = 'no date';
        }

        if (@$line->name == null) {
            $errors[] = 'no name';
        }

        if (@$line->address == null) {
            $errors[] = 'no address';
        }

        return $errors;
    }

    public function complete($line) : void
    {
    }
}

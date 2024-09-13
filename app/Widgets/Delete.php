<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class Delete extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];
    protected $dt = false;

    function __construct($config){
        $this->dt = isset($config['dt']) ? $config['dt'] : false;
    }
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //

        return view('widgets.delete', [
            'dt' => $this->dt,
        ]);
    }
}

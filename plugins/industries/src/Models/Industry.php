<?php

namespace Dot\Industries\Models;

use Dot\Platform\Model;
/*
 * Class Block
 * @package Dot\Blocks\Models
 */
class Industry extends Model
{

    /*
     * @var bool
     */
    public $timestamps = false;
    /*
     * @var string
     */
    protected $table = "industries";
    /*
     * @var string
     */
    protected $primaryKey = 'id';
    /*
     * @var array
     */
    protected $searchable = ['name'];
    /*
     * @var int
     */
    protected $perPage = 20;
    /*
     * @var array
     */
    protected $creatingRules = [
        "name" => "required",
    ];

    /*
     * @var array
     */
    protected $updatingRules = [
        "name" => "required",
    ];

    /*
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    }

    /*
     * @param $v
     * @return mixed
     */
    function setValidation($v)
    {
        $v->setCustomMessages((array)trans('languages::validation'));
        $v->setAttributeNames((array)trans("languages::languages.attributes"));
        return $v;
    }

}

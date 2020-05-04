<?php

namespace Dot\Industries\Controllers;

use Action;
use Dot\Industries\Models\Industry;
use Dot\Platform\Controller;
use Redirect;
use Request;
use View;

/*
 * Class IndustrysController
 * @package Dot\Industrys\Controllers
 */
class IndustriesController extends Controller
{

    /*
     * View payload
     * @var array
     */
    protected $data = [];

    /*
     * Show all Industrys
     * @return mixed
     */
    function index()
    {

        if (Request::isMethod("post")) {
            if (Request::filled("action")) {
                switch (Request::get("action")) {
                    case "delete":
                        return $this->delete();
                }
            }
        }

        $this->data["sort"] = $sort = (Request::filled("sort")) ? Request::get("sort") : "id";
        $this->data["order"] = $order = (Request::filled("order")) ? Request::get("order") : "DESC";
        $this->data['per_page'] = (Request::filled("per_page")) ? (int)Request::get("per_page") : 40;

        $query = Industry::orderBy($this->data["sort"], $this->data["order"]);

        if (Request::filled("q")) {
            $query->search(Request::get("q"));
        }

        $industries = $query->paginate($this->data['per_page']);

        $this->data["industries"] = $industries;

        return View::make("industries::show", $this->data);
    }

    /*
     * Delete industry by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $industry = Industry::findOrFail($id);
            $industry->delete();
        }

        return Redirect::back()->with("message", trans("industries::industries.events.deleted"));
    }

    /*
     * Create a new Industry
     * @return mixed
     */
    public function create()
    {

        if (Request::isMethod("post")) {

            $industry = new Industry();

            $industry->name = Request::get("name");
            $industry->logo = Request::get("logo");

            if (!$industry->validate()) {
                return Redirect::back()->withErrors($industry->errors())->withInput(Request::all());
            }

            $industry->save();

            return Redirect::route("admin.industries.edit", array("industry_id" => $industry->id))
                ->with("message", trans("industries::industries.events.created"));
        }

        $this->data["industry"] = false;
        return View::make("industries::edit", $this->data);
    }

    /*
     * Edit industry by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $industry = Industry::findOrFail($id);

        if (Request::isMethod("post")) {

            $industry->name = Request::get("name");
            $industry->logo = Request::get("logo");


            if (!$industry->validate()) {
                return Redirect::back()->withErrors($industry->errors())->withInput(Request::all());
            }
            return Redirect::route("admin.industries.edit", array("industry_id" => $id))->with("message", trans("industries::industries.events.updated"));
        }

        $this->data["industry"] = $industry;
        return View::make("industries::edit", $this->data);
    }

    /*
     * Rest Service to search industries
     * @return string
     */
    function search()
    {

        $q = trim(urldecode(Request::get("q")));

        $industries = Industry::search($q)->get()->toArray();

        return json_encode($industries);
    }
}

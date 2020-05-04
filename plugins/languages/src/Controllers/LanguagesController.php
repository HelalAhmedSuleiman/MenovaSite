<?php

namespace Dot\Languages\Controllers;

use Action;
use Dot\Languages\Models\Language;
use Dot\Platform\Controller;
use Redirect;
use Request;
use View;

/*
 * Class LanguagesController
 * @package Dot\Languages\Controllers
 */
class LanguagesController extends Controller
{

    /*
     * View payload
     * @var array
     */
    protected $data = [];

    /*
     * Show all Languages
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

        $query = Language::orderBy($this->data["sort"], $this->data["order"]);

        if (Request::filled("q")) {
            $query->search(Request::get("q"));
        }

        $languages = $query->paginate($this->data['per_page']);

        $this->data["languages"] = $languages;

        return View::make("languages::show", $this->data);
    }

    /*
     * Delete language by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $language = Language::findOrFail($id);
            $language->delete();
        }

        return Redirect::back()->with("message", trans("languages::languages.events.deleted"));
    }

    /*
     * Create a new Language
     * @return mixed
     */
    public function create()
    {

        if (Request::isMethod("post")) {

            $language = new Language();

            $language->name = Request::get("name");

            if (!$language->validate()) {
                return Redirect::back()->withErrors($language->errors())->withInput(Request::all());
            }

            $language->save();

            return Redirect::route("admin.languages.edit", array("language_id" => $language->id))
                ->with("message", trans("languages::languages.events.created"));
        }

        $this->data["language"] = false;
        return View::make("languages::edit", $this->data);
    }

    /*
     * Edit language by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $language = Language::findOrFail($id);

        if (Request::isMethod("post")) {

            $language->name = Request::get("name");

            if (!$language->validate()) {
                return Redirect::back()->withErrors($language->errors())->withInput(Request::all());
            }
            return Redirect::route("admin.languages.edit", array("language_id" => $id))->with("message", trans("languages::languages.events.updated"));
        }

        $this->data["language"] = $language;
        return View::make("languages::edit", $this->data);
    }

    /*
     * Rest Service to search languages
     * @return string
     */
    function search()
    {

        $q = trim(urldecode(Request::get("q")));

        $languages = Language::search($q)->get()->toArray();

        return json_encode($languages);
    }
}

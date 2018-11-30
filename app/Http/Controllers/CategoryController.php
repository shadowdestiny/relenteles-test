<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAll()
    {
         return Category::all();
    }

    public function createCategory(Request $request)
    {

        $this->validate($request,[
            'name' => 'required|max:50|unique:categories',
            'description' => 'required|max:200',
        ]);

        if ($request->isJson()) {
            $data = $request->json()->all();
            $category = new Category();
            $category->name         = $data['name'];
            $category->description  = $data['description'];
            $category->save();

            return response()->json($category, 201);

        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function updateCategory(Request $request, $id)
    {
        if ($request->isJson()) {

            $this->validate($request,[
                'name' => 'required|max:50',
                'description' => 'required|max:200',
            ]);

            try {
                $category = Category::findOrFail($id);

                $data = $request->json()->all();

                if (Category::where('id','<>',$id)->where('name','=',$data['name'])->first()) {
                    return response()->json(['error' => 'Other category is assigned this name'], 406);
                } else {

                        $category->name         = $data["name"];
                        $category->description  = $data["description"];

                        $category->save();

                        return response()->json($category, 200);

                }

            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }

        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function getCategory($id)
    {

            try {
                $category = Category::find($id);
                return response()->json($category, 200);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }


    }

    public function deleteCategory($id)
    {

        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json($category, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No content'], 406);
        }

    }

}

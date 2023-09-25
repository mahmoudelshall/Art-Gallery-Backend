<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'id' => 'required|integer|exists:categories,id',
            'name' => 'string|max:100|unique:categories,name,'. $this->id,
        ];
    }

    public function updateCategory($id): Category
    {
        $category = Category::find($id);
        $category->update([
            'name' =>isset( $this->name)? $this->name:$category['name']
        ]);

        return $category;
    }
}

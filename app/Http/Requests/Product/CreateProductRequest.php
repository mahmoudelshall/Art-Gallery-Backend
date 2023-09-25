<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
           'name' => 'required|string|max:100|unique:products',
           'category_id' => 'required|integer|max:100|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'required|string',
            'status' => 'required|boolean',
            'image' => 'required|image|max:2048',// mimes:jpg,jpeg,png,gif|

        ];
    }
    public function createProduct()
    {

        // Retrieve the uploaded file
        $imageFile = $this->file('image');
        // Generate a unique name for the image file
        $imageName = uniqid() . '.' . $imageFile->getClientOriginalExtension();
        // Save the image file
        $imageFile->storeAs('public/images', $imageName);

        return Product::create([
            'name' => $this->name,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'stock' => $this->stock,
            'description' => $this->description,
            'status' => $this->status,
            'image' => $imageName,
        ]);

    }
}

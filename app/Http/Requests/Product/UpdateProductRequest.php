<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Storage;

class UpdateProductRequest extends FormRequest
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
            'id' => 'required|integer|exists:products,id', // used it for unique in name but used in  updateProduct($id) for resource api
            'name' => 'string|max:100|unique:products,name,'. $this->id,
            'category_id' => 'integer|max:100|exists:categories,id',
            'price' => 'numeric',
            'stock' => 'integer',
            'description' => 'string',
            'status' => 'boolean',
            'image' => 'image|max:2048',// mimes:jpeg,png,jpg,gif|

        ];
      
    }

    public function updateProduct($id): Product
    {
        $Product = Product::find($id);
        $imageFile = @$this->file('image');
        if (isset($imageFile)) {
            // Generate a unique name for the image file
            $imageName = uniqid() . '.' . $imageFile->getClientOriginalExtension();
            // Save the image file
            $imageFile->storeAs('public/images', $imageName);
            // delete old image
            Storage::disk('public')->delete('images/' . $Product['image']);
        }

        $Product->update([
            'name' => isset($this->name) ? $this->name : $Product['name'],
            'category_id' => isset($this->category_id) ? $this->category_id : $Product['category_id'],
            'price' => isset($this->price) ? $this->price : $Product['price'],
            'stock' => isset($this->stock) ? $this->stock : $Product['stock'],
            'description' => isset($this->description) ? $this->description : $Product['description'],
            'status' => isset($this->status) ? $this->status : $Product['status'],
            'image' => isset($this->image) ? $imageName : $Product['image'],
        ]);

        return $Product;
    }
}

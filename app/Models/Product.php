<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 *  @OA\Schema(
 *      schema="Product",
 *      description="Producto de la tienda",
 *      type="object",
 *      required={"code","sku","name","image","image","cost","price","stock","min","model","trademark","category_id","tags"},
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          readOnly=true,
 *          description="Id del producto en la base de datos"
 *      ),
 *      @OA\Property(
 *          property="code",
 *          type="integer",
 *          description="Código de barras del producto"
 *      ),
 *      @OA\Property(
 *          property="sku",
 *          type="string",
 *          description="Código SKU del producto",
 *          minLength=3,
 *          maxLength=5
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Nombre del producto",
 *          minLength=3,
 *          maxLength=100
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          description="Descripción del producto",
 *          minLength=3,
 *          maxLength=700
 *      ),
 *      @OA\Property(
 *          property="image",
 *          type="string",
 *          description="Path de la imagen del producto",
 *          readOnly=true
 *      ),
 *      @OA\Property(
 *          property="cost",
 *          type="double",
 *          description="Coste de adquisición del producto",
 *      ),
 *      @OA\Property(
 *          property="price",
 *          type="double",
 *          description="Precio de venta del producto",
 *      ),
 *      @OA\Property(
 *          property="offer",
 *          type="double",
 *          description="Precio de oferta del producto o <code>null</code> si el producto no está en oferta",
 *          default="null"
 *      ),
 *      @OA\Property(
 *          property="stock",
 *          type="integer",
 *          description="Cantidad de productos disponibles para la venta en la tienda",
 *      ),
 *      @OA\Property(
 *          property="min",
 *          type="integer",
 *          description="Número mínimo de productos que pueden haber en stock",
 *      ),
 *      @OA\Property(
 *          property="model",
 *          type="string",
 *          description="Modelo del producto",
 *          minLength=3,
 *          maxLength=100
 *      ),
 *      @OA\Property(
 *          property="trademark",
 *          type="string",
 *          description="Marca del producto",
 *          minLength=3,
 *          maxLength=50
 *      ),
 *      @OA\Property(
 *          property="type",
 *          type="string",
 *          description="Tipo de producto",
 *          enum={"Físico","Digital"},
 *          default="Físico"
 *      ),
 *      @OA\Property(
 *          property="category_id",
 *          type="integer",
 *          description="Id de la categoría del producto",
 *      ),
 *      @OA\Property(
 *          property="category",
 *          type="object",
 *          readOnly="true",
 *          description="Categoría del producto",
 *          allOf={
 *              @OA\Schema(ref="#/components/schemas/Category")
 *          }
 *      ),
 *      @OA\Property(
 *          property="state",
 *          type="string",
 *          description="Estado del producto",
 *          enum={"Activo","Inactivo"},
 *          default="Activo"
 *      ),
 *      @OA\Property(
 *          property="tags",
 *          type="array",
 *          description="Etiquetas del producto",
 *          @OA\Items(
 *              type="string"
 *          )
 *      ),
 *  ),
 */
class Product extends BaseModel
{
    use HasFactory;

    /**
     * Indicar que el modelo no maneja columnas created_at y updated_at
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Crear un array a partir de las etiquetas del producto e incluirlo como un atributo más del modelo
     * 
     * @return array Etiquetas del modelo agrupadas en un Array
     */
    public function getTagsAttribute()
    {
        return Str::of($this->attributes['tags'])->explode(',');
    }

    /**
     * Obtener la categoría del producto
     * 
     * @return Category El modelo de la categoría del producto
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Obtener la categoría del producto
     * 
     * @return Color Todos los colores disponibles para este producto
     */
    public function colors()
    {
        return $this->hasMany(Color::class);
    }

    /**
     * Incluir la categoria del producto en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->category) {
            $data['category'] = $this->category->name;
        } else {
            $data['category'] = null;
        }
        if ($this->colors) {
            $data['colors'] = $this->colors;
        } else {
            $data['colors'] = [];
        }
        return $data;
    }
}

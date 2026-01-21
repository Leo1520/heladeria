<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            // Helados Cremosos
            [
                'nombre' => 'Helado de Vainilla',
                'descripcion' => 'Clásico helado de vainilla francesa con extracto natural',
                'precio' => 12.00,
                'stock' => 50,
                'disponible' => true,
                'categoria' => 'Cremosos',
                'sabor' => 'Vainilla',
                'tamano' => '1L',
            ],
            [
                'nombre' => 'Helado de Chocolate',
                'descripcion' => 'Intenso helado de chocolate belga con cacao premium',
                'precio' => 14.00,
                'stock' => 45,
                'disponible' => true,
                'categoria' => 'Cremosos',
                'sabor' => 'Chocolate',
                'tamano' => '1L',
            ],
            [
                'nombre' => 'Helado de Lúcuma',
                'descripcion' => 'Tradicional helado peruano de lúcuma natural',
                'precio' => 13.00,
                'stock' => 40,
                'disponible' => true,
                'categoria' => 'Cremosos',
                'sabor' => 'Lúcuma',
                'tamano' => '1L',
            ],
            // Helados Frutales
            [
                'nombre' => 'Helado de Fresa',
                'descripcion' => 'Refrescante helado de fresas frescas seleccionadas',
                'precio' => 11.00,
                'stock' => 35,
                'disponible' => true,
                'categoria' => 'Frutales',
                'sabor' => 'Fresa',
                'tamano' => '1L',
            ],
            [
                'nombre' => 'Helado de Maracuyá',
                'descripcion' => 'Exótico helado de maracuyá con pulpa natural',
                'precio' => 12.00,
                'stock' => 30,
                'disponible' => true,
                'categoria' => 'Frutales',
                'sabor' => 'Maracuyá',
                'tamano' => '1L',
            ],
            [
                'nombre' => 'Helado de Mango',
                'descripcion' => 'Delicioso helado de mango peruano maduro',
                'precio' => 11.50,
                'stock' => 28,
                'disponible' => true,
                'categoria' => 'Frutales',
                'sabor' => 'Mango',
                'tamano' => '1L',
            ],
            // Helados Premium
            [
                'nombre' => 'Helado de Pistacho',
                'descripcion' => 'Exclusivo helado de pistacho italiano con trozos reales',
                'precio' => 18.00,
                'stock' => 20,
                'disponible' => true,
                'categoria' => 'Premium',
                'sabor' => 'Pistacho',
                'tamano' => '1L',
            ],
            [
                'nombre' => 'Helado de Cookies & Cream',
                'descripcion' => 'Cremoso helado con galletas Oreo trituradas',
                'precio' => 16.00,
                'stock' => 25,
                'disponible' => true,
                'categoria' => 'Premium',
                'sabor' => 'Cookies & Cream',
                'tamano' => '1L',
            ],
            [
                'nombre' => 'Helado de Brownie',
                'descripcion' => 'Helado de chocolate con trozos de brownie casero',
                'precio' => 17.00,
                'stock' => 22,
                'disponible' => true,
                'categoria' => 'Premium',
                'sabor' => 'Brownie',
                'tamano' => '1L',
            ],
            // Tamaños individuales
            [
                'nombre' => 'Cono de Vainilla',
                'descripcion' => 'Cono crujiente con helado de vainilla',
                'precio' => 5.00,
                'stock' => 100,
                'disponible' => true,
                'categoria' => 'Individual',
                'sabor' => 'Vainilla',
                'tamano' => 'Cono',
            ],
            [
                'nombre' => 'Cono de Chocolate',
                'descripcion' => 'Cono crujiente con helado de chocolate',
                'precio' => 5.50,
                'stock' => 95,
                'disponible' => true,
                'categoria' => 'Individual',
                'sabor' => 'Chocolate',
                'tamano' => 'Cono',
            ],
            [
                'nombre' => 'Copa de Fresa',
                'descripcion' => 'Copa con helado de fresa y topping de fruta',
                'precio' => 6.00,
                'stock' => 80,
                'disponible' => true,
                'categoria' => 'Individual',
                'sabor' => 'Fresa',
                'tamano' => 'Copa',
            ],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}

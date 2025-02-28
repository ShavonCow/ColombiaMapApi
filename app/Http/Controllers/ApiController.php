<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        // Obtener información de Colombia
        $countryResponse = Http::withOptions(['verify' => false])
            ->get('https://api-colombia.com/api/v1/Country/Colombia');

        if ($countryResponse->successful()) {
            $colombia_info = $countryResponse->json();
            
            return view('colombia', compact('colombia_info'));
        }

        return abort(500, 'Error al obtener datos de la API');
    }

    public function departments($id)
    {
        // Obtener información de Departamentos
        $departmentResponse = Http::withOptions(['verify' => false])
            ->get("https://api-colombia.com/api/v1/Department/{$id}");

        // Obtener información de Attraciones Turisticas
        $departmentTouristattractionsResponse = Http::withOptions(['verify' => false])
            ->get("https://api-colombia.com/api/v1/Department/{$id}/touristicattractions");

        if ($departmentResponse->successful()) {
            $department_info = $departmentResponse->json();
            $touristAttraction_info = $departmentTouristattractionsResponse->json();
            
            return view('colombia-state', compact('department_info', 'touristAttraction_info'));
        }
    
        return abort(404, 'Departamento no encontrado');
    }    
}

<?php

namespace App\Http\Controllers;

use App\Models\Employee; // Alterado para usar Employee
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller {

	// Exibe a página principal
	public function index() {
		return view('index');
	}

	// Busca todos os produtos via AJAX
	public function fetchAll() {
		$employees = Employee::all(); // Alterado para usar Employee
		$output = '';
		if ($employees->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Data de Validade</th>
                <th>Categoria</th>
                <th>Ação</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($employees as $employee) {
				$output .= '<tr>
                <td>' . $employee->id . '</td>
                <td><img src="storage/images/' . $employee->imagem . '" width="50" class="img-thumbnail"></td>
                <td>' . $employee->nome . '</td>
                <td>' . $employee->descricao . '</td>
                <td>' . $employee->preco . '</td>
                <td>' . $employee->data_validade . '</td>
                <td>' . $employee->categoria . '</td>
                <td>
                  <a href="#" id="' . $employee->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editProductModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $employee->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my5">Nenhum registro presente no banco de dados!</h1>';
		}
	}

	// Insere um novo produto via AJAX
	public function store(Request $request) {
        $file = $request->file('imagem');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $fileName);
    
        $employeeData = [
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'data_validade' => $request->data_validade,
            'categoria' => $request->categoria,
            'imagem' => $fileName,
        ];
    
        Employee::create($employeeData); // Alterado para usar Employee
    
        return response()->json([
            'status' => 200,
            'message' => 'Produto criado com sucesso'
        ]);
    }
    

	// Edita um produto via AJAX
	public function edit(Request $request) {
		$id = $request->id;
		$employee = Employee::find($id); // Alterado para usar Employee
		return response()->json($employee);
	}

	// Atualiza um produto via AJAX
	public function update(Request $request) {
		$fileName = '';
		$employee = Employee::find($request->employee_id); // Alterado para usar Employee
		if ($request->hasFile('imagem')) {
			$file = $request->file('imagem');
			$fileName = time() . '.' . $file->getClientOriginalExtension();
			$file->storeAs('public/images', $fileName);
			if ($employee->imagem) {
				Storage::delete('public/images/' . $employee->imagem);
			}
		} else {
			$fileName = $request->employee_image;
		}

		$employeeData = [
			'nome' => $request->nome,
			'descricao' => $request->descricao,
			'preco' => $request->preco,
			'data_validade' => $request->data_validade,
			'categoria' => $request->categoria,
			'imagem' => $fileName,
		];

		$employee->update($employeeData); // Alterado para usar Employee
		return response()->json([
			'status' => 200,
		]);
	}

	// Deleta um produto via AJAX
	public function delete(Request $request) {
		$id = $request->id;
		$employee = Employee::find($id); // Alterado para usar Employee
		if (Storage::delete('public/images/' . $employee->imagem)) {
			Employee::destroy($id); // Alterado para usar Employee
		}
	}
}

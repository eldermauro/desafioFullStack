<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Aplicação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/bs5/dt-2.1.4/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

{{-- Modal para adicionar novo produto --}}
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar Novo Produto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('store') }}" method="POST" id="add_product_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="my-2">
            <label for="nome">Nome</label>
            <input type="text" name="nome" class="form-control" placeholder="Nome do Produto" required>
          </div>
          <div class="my-2">
            <label for="descricao">Descrição</label>
            <textarea name="descricao" class="form-control" placeholder="Descrição do Produto" required></textarea>
          </div>
          <div class="my-2">
            <label for="preco">Preço</label>
            <input type="number" name="preco" class="form-control" placeholder="Preço" required>
          </div>
          <div class="my-2">
            <label for="data_validade">Data de Validade</label>
            <input type="date" name="data_validade" class="form-control" required>
          </div>
          <div class="my-2">
            <label for="categoria">Categoria</label>
            <select name="categoria" class="form-control" required>
              <!-- As opções de categoria devem ser geradas dinamicamente a partir do banco de dados -->
              <option value="">Selecione uma Categoria</option>
              <option value="Categoria1">Categoria 1</option>
              <option value="Categoria2">Categoria 2</option>
              <!-- Adicione mais categorias conforme necessário -->
            </select>
          </div>
          <div class="my-2">
            <label for="imagem">Imagem</label>
            <input type="file" name="imagem" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="submit" id="add_product_btn" class="btn btn-primary">Adicionar Produto</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- Fim do modal para adicionar novo produto --}}

{{-- Modal para editar produto --}}
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Produto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('update') }}" method="POST" id="edit_product_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="product_id" id="product_id">
        <input type="hidden" name="product_image" id="product_image">
        <div class="modal-body p-4 bg-light">
          <div class="my-2">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="edit_nome" class="form-control" placeholder="Nome do Produto" required>
          </div>
          <div class="my-2">
            <label for="descricao">Descrição</label>
            <textarea name="descricao" id="edit_descricao" class="form-control" placeholder="Descrição do Produto" required></textarea>
          </div>
          <div class="my-2">
            <label for="preco">Preço</label>
            <input type="number" name="preco" id="edit_preco" class="form-control" placeholder="Preço" required>
          </div>
          <div class="my-2">
            <label for="data_validade">Data de Validade</label>
            <input type="date" name="data_validade" id="edit_data_validade" class="form-control" required>
          </div>
          <div class="my-2">
            <label for="categoria">Categoria</label>
            <select name="categoria" id="edit_categoria" class="form-control" required>
              <!-- As opções de categoria devem ser geradas dinamicamente a partir do banco de dados -->
              <option value="">Selecione uma Categoria</option>
              <option value="Categoria1">Categoria 1</option>
              <option value="Categoria2">Categoria 2</option>
              <!-- Adicione mais categorias conforme necessário -->
            </select>
          </div>
          <div class="my-2">
            <label for="imagem">Imagem</label>
            <input type="file" name="imagem" class="form-control">
          </div>
          <div class="mt-2" id="image_preview">
            <!-- A imagem atual do produto será exibida aqui -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="submit" id="edit_product_btn" class="btn btn-success">Atualizar Produto</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- Fim do modal para editar produto --}}

<div class="container">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow">
          <div class="card-header bg-success d-flex justify-content-between align-items-center">
            <h3 class="text-light">Produtos Cadastrados</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addProductModal"><i class="bi-plus-circle me-2"></i>Adicionar novo Produto</button>
          </div>
          <div class="card-body" id="show_all_products">
            <h1 class="text-center text-secondary my-5">Carregando...</h1>
          </div>
        </div>
      </div>
    </div>
  </div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-2.1.4/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

$("#add_product_form").submit(function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    $("#add_product_btn").text('Adding...');
    $.ajax({
      url: '{{ route('store') }}',  // Verifique se a rota está correta
      method: 'post',  // O método está correto
      data: fd,
      cache: false,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function(response) {
        if (response.status == 200) {
          Swal.fire(
            'Added!',
            'Produto Adicionado com Sucesso!',
            'success'
          )
          fetchAllProducts();
        }
        $("#add_product_btn").text('Adicionar Produto');
        $("#add_product_form")[0].reset();
        $("#addProductModal").modal('hide');
      }
    });
});



    // Editar produto AJAX request
    $(document).on('click', '.editIcon', function(e) {
    e.preventDefault();
    let id = $(this).attr('id');
    $.ajax({
      url: '{{ route('edit') }}',
      method: 'get',  // Método correto para a rota edit
      data: {
        id: id,
        _token: '{{ csrf_token() }}'
      },
      success: function(response) {
        $("#edit_nome").val(response.nome);
        $("#edit_descricao").val(response.descricao);
        $("#edit_preco").val(response.preco);
        $("#edit_data_validade").val(response.data_validade);
        $("#edit_categoria").val(response.categoria);
        $("#product_id").val(response.id);
        $("#product_image").val(response.imagem);
        if (response.imagem) {
            $("#image_preview").html(`<img src="/images/${response.imagem}" width="100" class="img-fluid img-thumbnail">`);
        }
      }
    });
});


    // Atualizar produto via AJAX
    $("#edit_product_form").submit(function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    $("#edit_product_btn").text('Updating...');
    $.ajax({
      url: '{{ route('update') }}',
      method: 'post',  // Método correto para a rota update
      data: fd,
      cache: false,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function(response) {
        if (response.status == 200) {
          Swal.fire(
            'Updated!',
            'Produto Atualizado com Sucesso!',
            'success'
          )
          fetchAllProducts();
        }
        $("#edit_product_btn").text('Atualizar Produto');
        $("#edit_product_form")[0].reset();
        $("#editProductModal").modal('hide');
      }
    });
});


    // Deletar produto via AJAX
    $$(document).on('click', '.deleteIcon', function(e) {
    e.preventDefault();
    let id = $(this).attr('id');
    let csrf = '{{ csrf_token() }}';
    Swal.fire({
      title: 'Você tem certeza?',
      text: "Essa ação não pode ser desfeita!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sim, deletar!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '{{ route('delete') }}',
          method: 'delete',  // Método correto para a rota delete
          data: {
            id: id,
            _token: csrf
          },
          success: function(response) {
            Swal.fire(
              'Deleted!',
              'Seu arquivo foi deletado.',
              'success'
            )
            fetchAllProducts();
          }
        });
      }
    })
});

    // Função para buscar todos os produtos via AJAX
    function fetchAllProducts() {
    $.ajax({
      url: '{{ route('fetchAll') }}',
      method: 'get',
      success: function(response) {
        $("#show_all_products").html(response);
        $("table").DataTable({
          order: [0, 'desc']
        });
      }
    });
}


</script>

</body>
</html>

<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <h2>Agregar Nueva Categoría</h2>
    
    <form action="index.php?controller=CategoriaController&action=agregar" method="post">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="index.php?controller=CategoriaController&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include __DIR__ . '/../partials/footer.php';  ?>
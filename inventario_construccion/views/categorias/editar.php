<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <h2>Editar Categoría</h2>
    
    <form action="index.php?controller=CategoriaController&action=editar&id=<?php echo $this->categoria->id; ?>" method="post">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $this->categoria->nombre; ?>" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo $this->categoria->descripcion; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php?controller=CategoriaController&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include __DIR__ . '/../partials/footer.php';  ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <h2>Agregar Nueva Herramienta</h2>
    
    <form action="index.php?controller=HerramientaController&action=agregar" method="post">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="categoria_id">Categoría:</label>
            <select class="form-control" id="categoria_id" name="categoria_id" required>
                <option value="">Seleccione una categoría</option>
                <?php while ($categoria = $categorias->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" class="form-control" id="stock" name="stock" min="0" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select class="form-control" id="estado" name="estado" required>
                <option value="Disponible">Disponible</option>
                <option value="En uso">En uso</option>
                <option value="Dañada">Dañada</option>
                <option value="En mantenimiento">En mantenimiento</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="index.php?controller=HerramientaController&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
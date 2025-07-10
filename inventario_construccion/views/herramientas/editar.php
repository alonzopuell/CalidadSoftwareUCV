<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <h2>Editar Herramienta</h2>
    
    <form action="index.php?controller=HerramientaController&action=editar&id=<?= $this->herramienta->id ?>" method="post">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" 
                   value="<?= htmlspecialchars($this->herramienta->nombre) ?>" required>
        </div>
        
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= 
                   htmlspecialchars($this->herramienta->descripcion) ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="categoria_id">Categoría:</label>
            <select class="form-control" id="categoria_id" name="categoria_id" required>
                <option value="">Seleccione una categoría</option>
                <?php while ($categoria = $categorias->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?= $categoria['id'] ?>" 
                    <?= ($categoria['id'] == $this->herramienta->categoria_id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($categoria['nombre']) ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" class="form-control" id="stock" name="stock" 
                   value="<?= htmlspecialchars($this->herramienta->stock) ?>" min="0" required>
        </div>
        
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select class="form-control" id="estado" name="estado" required>
                <option value="Disponible" <?= ($this->herramienta->estado == 'Disponible') ? 'selected' : '' ?>>Disponible</option>
                <option value="En uso" <?= ($this->herramienta->estado == 'En uso') ? 'selected' : '' ?>>En uso</option>
                <option value="Dañada" <?= ($this->herramienta->estado == 'Dañada') ? 'selected' : '' ?>>Dañada</option>
                <option value="Mantenimiento" <?= ($this->herramienta->estado == 'Mantenimiento') ? 'selected' : '' ?>>En mantenimiento</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php?controller=HerramientaController&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
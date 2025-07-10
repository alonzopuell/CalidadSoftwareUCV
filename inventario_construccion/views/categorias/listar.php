<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <h2>Listado de Categorías</h2>
    <a href="index.php?controller=CategoriaController&action=agregar" class="btn btn-primary mb-3">Agregar Categoría</a>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultado->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['descripcion']; ?></td>
                <td>
                    <a href="index.php?controller=CategoriaController&action=editar&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="index.php?controller=CategoriaController&action=eliminar&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../partials/footer.php';  ?>
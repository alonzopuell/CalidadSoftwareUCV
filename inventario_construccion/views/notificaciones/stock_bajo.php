<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <h2>Notificaciones de Stock Bajo</h2>
    
    <div class="mb-3">
        <a href="index.php?controller=NotificacionController&action=verificarStockBajo" 
           class="btn btn-primary">
           Verificar Stock Ahora
        </a>
    </div>
    
    <?php if (isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-success"><?= $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
    <?php endif; ?>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Item</th>
                <th>Mensaje</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $itemsMostrados = [];
            while ($notificacion = $notificaciones->fetch(PDO::FETCH_ASSOC)): 
                // Evitar duplicados mostrando solo la más reciente por item
                $clave = $notificacion['tipo'].'_'.$notificacion['item_id'];
                if (!in_array($clave, $itemsMostrados)):
                    $itemsMostrados[] = $clave;
            ?>
            <tr class="<?= $notificacion['leida'] ? '' : 'table-warning' ?>">
                <td><?= date('d/m/Y H:i', strtotime($notificacion['fecha'])) ?></td>
                <td><?= ucfirst($notificacion['tipo']) ?></td>
                <td>
                    <?php if ($notificacion['tipo'] == 'producto'): ?>
                    <a href="index.php?controller=ProductoController&action=editar&id=<?= $notificacion['item_id'] ?>">
                        Ver Producto
                    </a>
                    <?php else: ?>
                    <a href="index.php?controller=HerramientaController&action=editar&id=<?= $notificacion['item_id'] ?>">
                        Ver Herramienta
                    </a>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($notificacion['mensaje']) ?></td>
                <td>
                    <?php if (!$notificacion['leida']): ?>
                    <a href="index.php?controller=NotificacionController&action=marcarLeida&id=<?= $notificacion['id'] ?>" 
                       class="btn btn-sm btn-success">
                        Marcar leída
                    </a>
                    <?php endif; ?>
                    <a href="index.php?controller=NotificacionController&action=eliminar&id=<?= $notificacion['id'] ?>" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('¿Eliminar esta notificación?')">
                        Eliminar
                    </a>
                </td>
            </tr>
            <?php 
                endif;
            endwhile; 
            ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
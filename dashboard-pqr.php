<?php
require_once 'config/db.php';

$sql = "SELECT * FROM pqr_solicitudes ORDER BY fecha_creacion DESC";
$stmt = $conn->query($sql);
$pqrs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PQR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Dashboard PQR</h2>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
                Nueva solicitud PQR registrada exitosamente.
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo PQR</th>
                        <th>Asunto</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pqrs as $pqr): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pqr['id']); ?></td>
                        <td><?php echo htmlspecialchars($pqr['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($pqr['tipo_pqr']); ?></td>
                        <td><?php echo htmlspecialchars($pqr['asunto']); ?></td>
                        <td><?php echo htmlspecialchars($pqr['fecha_creacion']); ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="viewDetails(<?php echo $pqr['id']; ?>)">Ver Detalles</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal for Details -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Detalles de la Solicitud</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function viewDetails(id) {
            fetch(`get_pqr_details.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    const content = `
                        <div class="container">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Nombre:</strong> ${data.nombre}
                                </div>
                                <div class="col-md-6">
                                    <strong>Email:</strong> ${data.email}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Documento:</strong> ${data.documento}
                                </div>
                                <div class="col-md-6">
                                    <strong>Teléfono:</strong> ${data.telefono}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Tipo PQR:</strong> ${data.tipo_pqr}
                                </div>
                                <div class="col-md-6">
                                    <strong>Fecha:</strong> ${data.fecha_creacion}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <strong>Asunto:</strong> ${data.asunto}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <strong>Descripción:</strong><br>
                                    ${data.descripcion}
                                </div>
                            </div>
                        </div>
                    `;
                    document.getElementById('modalContent').innerHTML = content;
                    new bootstrap.Modal(document.getElementById('detailsModal')).show();
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
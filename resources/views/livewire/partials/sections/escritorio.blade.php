{{-- Vista: Escritorio Principal --}}
<div class="row g-4">
    <div class="col-md-4">
        <div class="widget-card card-miUsuario">
            <h4 class="mt-3">¡Buenos días, {{ Auth::user()->nombre }}!</h4>
            <div class="py-4">
                <img src="https://acceso2.intranext.es/assets/images/avatares/mujer_azul.png"
                    class="rounded-circle border border-white" style="width: 100px;">
            </div>
            <p class="mb-4">Tienes 3 tareas pendientes para hoy.</p>
        </div>
    </div>
    <div class="col-md-8">
        <div class="widget-card">
            <h5>Tareas Recientes</h5>
            <table class="table table-sm mt-3">
                <thead class="table-light">
                    <tr>
                        <th>Tarea</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Revisión de actas</td>
                        <td><span class="badge bg-warning">Pendiente</span></td>
                    </tr>
                    <tr>
                        <td>Firma de contratos Axis Gestora</td>
                        <td><span class="badge bg-success">Completado</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
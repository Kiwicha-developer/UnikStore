<button class="btn {{$clases}}" data-bs-toggle="modal" data-bs-target="#nuevoClienteModal"><i class="bi bi-person-fill-add" ></i> Nuevo Cliente</button>


<div class="modal fade" id="nuevoClienteModal" tabindex="-1" aria-labelledby="nuevoClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="nuevoClienteModalLabel">Nuevo Cliente</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row text-start">
                <div class="col-12">
                    <label class="form-label">Nombres:</label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-6">
                    <label class="form-label">Apellido Paterno:</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Apellido Materno:</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Documento:</label>
                    <select name="" class="form-select" required>

                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label">Nro Documento:</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Nro Telefono:</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Correo Electronico:</label>
                    <input type="text" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" onclick="return confirm('¿Estas seguro?')" class="btn btn-primary">Guardar</button>
        </div>
        </div>
    </div>
    </div>
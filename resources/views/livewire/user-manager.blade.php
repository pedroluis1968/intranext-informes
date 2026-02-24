<div>
    <div class="card">
        <div class="card-header">
            <h2>Gestión de Usuarios - Intranext</h2>
        </div>
        <div class="card-body">
            @if ($error_msg)
                <div class="alert alert-danger"
                    style="background: #fee2e2; color: #991b1b; border: 1px solid #f87171; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <strong>⚠️ Error de Base de Datos:</strong><br>
                    {{ $error_msg }}
                </div>
            @endif

            <!-- Buscador -->
            <div class="search-container">
                <input type="text" wire:model="search" placeholder="🔍 Buscar por nombre, email o puesto..."
                    class="search-input">
            </div>

            <table class="custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Puesto</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td><strong>{{ $user->nombre }}</strong></td>
                            <td><span class="badge">{{ $user->puesto }}</span></td>
                            <td>{{ $user->email }}</td>
                        </tr>
                    @empty
                        @if(!$error_msg)
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8;">
                                    No se encontraron usuarios que coincidan con "{{ $search }}"
                                </td>
                            </tr>
                        @endif
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 20px;
            color: #1e293b;
        }

        .card-header {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .card-body {
            padding: 20px;
        }

        /* Buscador */
        .search-container {
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        .search-input:focus {
            border-color: #6366f1;
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .custom-table th,
        .custom-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f1f5f9;
        }

        .custom-table th {
            background-color: #f8fafc;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.05em;
        }

        .custom-table tr:hover {
            background-color: #f8fafc;
        }

        .badge {
            background: #e0e7ff;
            color: #4338ca;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
        }
    </style>
</div>
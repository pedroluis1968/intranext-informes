{{-- Estilos del escritorio principal --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/gridstack@7.2.3/dist/gridstack.min.css" />

<style>
    .page-header-custom {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
        animation: fadeInRight 0.5s ease-out;
    }

    .page-header-icon {
        width: 65px;
        height: 65px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.5rem;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .page-header-text h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        color: #042a3c;
    }

    .page-header-text p {
        margin: 0;
        color: #6c757d;
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Re-usando los estilos de los widgets anteriores */
    .widget-card {
        border: 1px solid #000;
        background-color: #fff;
        border-radius: 16px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        padding: 15px;
    }

    .card-miUsuario {
        background: linear-gradient(to bottom right, rgba(92, 198, 208, 1) 0%, rgb(84, 192, 202, 0.8) 15%, rgba(36, 202, 211, 0.9) 30%, rgba(0, 0, 0, 0.8) 70%, rgba(0, 0, 0, 0.95) 100%);
        border: none;
        color: white;
        text-align: center;
    }

    .coop-card {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        cursor: pointer;
        border: 2px solid #042a3c;
        background: #fff;
        position: relative;
        overflow: hidden;
        height: 100%;
        border-radius: 16px;
        box-shadow: 8px 8px 15px rgba(4, 42, 60, 0.45);
        display: flex;
        flex-direction: column;
        padding: 20px;
    }

    .coop-card:hover {
        transform: translateY(-8px);
        box-shadow: 12px 12px 25px rgba(4, 42, 60, 0.55) !important;
    }

    .coop-status-badge {
        position: absolute;
        top: 15px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 0.7rem;
        padding: 4px 12px;
        border-radius: 50px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        z-index: 2;
    }

    .status-activa {
        background: #e3f9ef;
        color: #10b981;
    }

    .status-finalizada {
        background: #f3f4f6;
        color: #6b7280;
    }

    .coop-icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        background: #f8fafc;
    }

    .coop-title {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .coop-info {
        font-size: 0.85rem;
        color: #64748b;
    }

    .coop-stats {
        margin-top: auto;
        padding-top: 1.5rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Toggle Switch Premium */
    .form-check-input:checked {
        background-color: #00d1e0;
        border-color: #00d1e0;
    }
</style>
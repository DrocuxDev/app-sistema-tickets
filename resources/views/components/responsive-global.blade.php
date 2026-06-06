{{-- Estilos responsive compartidos — reglas conservadoras, sin !important salvo casos puntuales --}}
<style>
/* Scroll horizontal seguro en tablas anchas */
@media (max-width: 768px) {
    .erp-table-container,
    .mt-table-wrap,
    .tk-table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .erp-pagination {
        flex-direction: column;
        gap: 12px;
        align-items: stretch;
        text-align: center;
    }
    .erp-pagination .pagination-controls {
        justify-content: center;
        flex-wrap: wrap;
    }
    .modal-form-footer {
        flex-direction: column-reverse;
        padding: 14px 16px 20px;
    }
    .modal-form-footer button {
        width: 100%;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .erp-table { min-width: 640px; }

    /* intl-tel-input en formularios de perfil */
    .iti { width: 100%; max-width: 100%; }
    .iti input[type="tel"] { width: 100%; }
}
</style>

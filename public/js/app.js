/**
 * Situação da Entrega - JavaScript Principal
 * Assets 100% locais - Sem CDN
 */

(function() {
    'use strict';

    /**
     * Inicialização quando DOM estiver pronto
     */
    document.addEventListener('DOMContentLoaded', function() {
        initMobileMenu();
        initFormValidation();
        initAlertDismiss();
    });

    /**
     * Menu Mobile (toggle)
     */
    function initMobileMenu() {
        const menuToggle = document.querySelector('.js-menu-toggle');
        const mobileMenu = document.querySelector('.js-mobile-menu');

        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('is-active');
                menuToggle.setAttribute(
                    'aria-expanded',
                    mobileMenu.classList.contains('is-active')
                );
            });
        }
    }

    /**
     * Validação básica de formulários
     */
    function initFormValidation() {
        const forms = document.querySelectorAll('form[data-validate]');

        forms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(function(field) {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    showAlert('Por favor, preencha todos os campos obrigatórios.', 'erro');
                }
            });
        });
    }

    /**
     * Fechar alertas automaticamente
     */
    function initAlertDismiss() {
        const alertas = document.querySelectorAll('.alerta[data-dismiss]');

        alertas.forEach(function(alerta) {
            const tempoMs = parseInt(alerta.dataset.dismiss) || 5000;

            setTimeout(function() {
                alerta.style.opacity = '0';
                alerta.style.transition = 'opacity 0.3s ease';
                
                setTimeout(function() {
                    alerta.remove();
                }, 300);
            }, tempoMs);
        });
    }

    /**
     * Mostrar alerta dinâmico
     */
    function showAlert(mensagem, tipo) {
        tipo = tipo || 'info';
        
        const alerta = document.createElement('div');
        alerta.className = 'alerta alerta--' + tipo;
        alerta.textContent = mensagem;
        alerta.setAttribute('data-dismiss', '5000');

        const main = document.querySelector('.main');
        if (main) {
            main.insertBefore(alerta, main.firstChild);
            initAlertDismiss();
        }
    }

    // Expor função para uso global se necessário
    window.SituacaoEntrega = {
        showAlert: showAlert
    };

})();

// Smooth scroll untuk anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }
    });
});

// Auto-close alert messages setelah 5 detik
const alerts = document.querySelectorAll('.alert');
alerts.forEach(alert => {
    setTimeout(() => {
        alert.style.transition = 'opacity 0.3s ease';
        alert.style.opacity = '0';
        setTimeout(() => {
            alert.style.display = 'none';
        }, 300);
    }, 5000);
});

// Validasi form sebelum submit
const forms = document.querySelectorAll('form');
forms.forEach(form => {
    form.addEventListener('submit', function(e) {
        const inputs = this.querySelectorAll('input[required], select[required]');
        let isValid = true;
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.style.borderColor = '#F1576C';
            } else {
                input.style.borderColor = '';
            }
        });

        if (!isValid) {
            e.preventDefault();
            console.warn('Form validation failed: Some required fields are empty');
        }
    });

    // Remove error style saat user mengetik
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.style.borderColor = '';
            }
        });
    });
});

// Loading state untuk button submit
const submitButtons = document.querySelectorAll('button[type="submit"]');
submitButtons.forEach(button => {
    button.addEventListener('click', function() {
        const originalText = this.textContent;
        this.textContent = 'Loading...';
        this.disabled = true;
        
        setTimeout(() => {
            this.textContent = originalText;
            this.disabled = false;
        }, 1000);
    });
});

// Konfirmasi delete dengan modal
const deleteLinks = document.querySelectorAll('a[onclick*="confirm"]');
deleteLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        const message = this.getAttribute('onclick');
        if (message.includes("Yakin")) {
            const userConfirm = confirm('Yakin ingin menghapus data ini?');
            if (!userConfirm) {
                e.preventDefault();
            }
        }
    });
});

// Responsive table untuk mobile
function makeTableResponsive() {
    const tables = document.querySelectorAll('.table');
    if (window.innerWidth < 768) {
        tables.forEach(table => {
            if (!table.classList.contains('responsive')) {
                table.classList.add('responsive');
            }
        });
    } else {
        tables.forEach(table => {
            table.classList.remove('responsive');
        });
    }
}

window.addEventListener('resize', makeTableResponsive);
makeTableResponsive();

// Add loading animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card, .alert {
        animation: fadeIn 0.3s ease;
    }

    .table.responsive {
        overflow-x: auto;
    }

    .table.responsive table {
        width: 100%;
        min-width: 600px;
    }
`;
document.head.appendChild(style);

// Add active nav link based on current page
const currentPage = window.location.pathname.split('/').pop() || 'index.php';
document.querySelectorAll('.nav-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPage || (currentPage === '' && href === 'index.php')) {
        link.classList.add('active');
    } else {
        link.classList.remove('active');
    }
});

// Tooltip functionality
const tooltips = document.querySelectorAll('[data-tooltip]');
tooltips.forEach(element => {
    element.addEventListener('mouseenter', function() {
        const tooltipText = this.getAttribute('data-tooltip');
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = tooltipText;
        tooltip.style.cssText = `
            position: absolute;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
            pointer-events: none;
        `;
        document.body.appendChild(tooltip);
        
        const rect = this.getBoundingClientRect();
        tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = (rect.top - tooltip.offsetHeight - 10) + 'px';

        setTimeout(() => tooltip.remove(), 3000);
    });
});


        function editProduct(product) {
            document.getElementById('edit-id').value = product.id;
            document.getElementById('edit-name').value = product.name;
            document.getElementById('edit-category').value = product.category;
            document.getElementById('edit-price').value = product.price;
            document.getElementById('edit-stock').value = product.stock;
        }

        // Function to show loading spinner
        function showLoading() {
            const loading = document.getElementById('loading');
            if (loading) {
                loading.style.display = 'block';
            }
        }

        // Function to hide loading spinner
        function hideLoading() {
            const loading = document.getElementById('loading');
            if (loading) {
                loading.style.display = 'none';
            }
        }

        // Add loading spinner to forms
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading spinner to create form
            const createForm = document.querySelector('form[action="../index.php/add"]');
            if (createForm) {
                createForm.addEventListener('submit', function() {
                    showLoading();
                });
            }

            // Add loading spinner to update form
            const updateForm = document.querySelector('form[action="../index.php/update"]');
            if (updateForm) {
                updateForm.addEventListener('submit', function() {
                    showLoading();
                });
            }

            // Auto-hide loading after 3 seconds (fallback)
            setTimeout(function() {
                hideLoading();
            }, 3000);
        });

        // Function to validate form inputs
        function validateForm(form) {
            const inputs = form.querySelectorAll('input[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            return isValid;
        }

        // Add form validation
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!validateForm(this)) {
                        e.preventDefault();
                        alert('Please fill in all required fields.');
                    }
                });
            });
        });

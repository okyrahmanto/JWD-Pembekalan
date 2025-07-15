
        function editProduct(product) {
            document.getElementById('edit-id').value = product.id;
            document.getElementById('edit-name').value = product.name;
            document.getElementById('edit-category').value = product.category;
            document.getElementById('edit-price').value = product.price;
            document.getElementById('edit-stock').value = product.stock;
        }

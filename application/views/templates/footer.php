    <!-- Scripts Wajib -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script Tambahan -->
    <?php if (isset($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?= base_url('assets/js/' . $script) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Inline JavaScript -->
    <script>
    $(document).ready(function() {
        // Auto close alert
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
        
        // Inisialisasi tooltip
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        <?php if (isset($inline_js)): ?>
            <?= $inline_js ?>
        <?php endif; ?>
    });
    </script>
</body>
</html>
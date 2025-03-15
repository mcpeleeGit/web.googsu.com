        <footer>
            <p>&copy; 2025 유틸리티 모음. All rights reserved.</p>
        </footer>
    </div>

    <?php if (isset($additional_js)): ?>
        <?php foreach ($additional_js as $js): ?>
            <script src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html> 
        <footer>
            <div class="footer-content">
                <p>&copy; 2025 유틸리티 모음. All rights reserved.</p>
                <nav class="footer-links">
                    <a href="/privacy-policy.php">개인정보 처리방침</a>
                </nav>
            </div>
        </footer>
    </div>

    <style>
    footer {
        margin-top: 2rem;
        padding: 1rem 0;
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .footer-links a {
        color: var(--mui-text-secondary);
        text-decoration: none;
        transition: color 0.2s;
    }

    .footer-links a:hover {
        color: var(--mui-primary);
    }

    @media (max-width: 768px) {
        .footer-content {
            flex-direction: column;
            text-align: center;
        }
    }
    </style>

    <?php if (isset($additional_js)): ?>
        <?php foreach ($additional_js as $js): ?>
            <script src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html> 
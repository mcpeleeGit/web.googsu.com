<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/language.php';

$current_lang = getCurrentLang();
$current_page = 'text-compare';

// 페이지별 언어 파일 로드
require_once "lang/text-compare/{$current_lang}.php";

$page_title = __('page.title');
$additional_css = ['css/text-compare.css'];
$additional_js = ['js/text-compare.js'];
include 'includes/header.php';
?>

<main class="container">
    <section class="tool-section">
        <h1><?php echo __('page.title'); ?></h1>
        <p class="tool-description"><?php echo __('page.description'); ?></p>

        <div class="text-compare-container">
            <div class="input-group">
                <div class="text-input">
                    <label for="text1"><?php echo __('input.text1_label'); ?></label>
                    <textarea id="text1" placeholder="<?php echo __('input.text1_placeholder'); ?>"></textarea>
                </div>
                <div class="text-input">
                    <label for="text2"><?php echo __('input.text2_label'); ?></label>
                    <textarea id="text2" placeholder="<?php echo __('input.text2_placeholder'); ?>"></textarea>
                </div>
            </div>

            <div class="options-panel">
                <h3><?php echo __('options.title'); ?></h3>
                <div class="options">
                    <label>
                        <input type="checkbox" id="ignoreCase">
                        <?php echo __('options.ignore_case'); ?>
                    </label>
                    <label>
                        <input type="checkbox" id="ignoreWhitespace">
                        <?php echo __('options.ignore_whitespace'); ?>
                    </label>
                    <label>
                        <input type="checkbox" id="ignorePunctuation">
                        <?php echo __('options.ignore_punctuation'); ?>
                    </label>
                </div>
            </div>

            <div class="button-group">
                <button id="compareBtn" class="primary-btn"><?php echo __('buttons.compare'); ?></button>
                <button id="clearBtn" class="secondary-btn"><?php echo __('buttons.clear'); ?></button>
                <button id="swapBtn" class="secondary-btn"><?php echo __('buttons.swap'); ?></button>
            </div>

            <div class="results-section">
                <h3><?php echo __('results.title'); ?></h3>
                <div id="compareResult"></div>
                <button id="copyResultBtn" class="secondary-btn" style="display: none;">
                    <?php echo __('buttons.copy_result'); ?>
                </button>
            </div>
        </div>

        <div class="help-section">
            <h3><?php echo __('help.title'); ?></h3>
            <p><?php echo __('help.description'); ?></p>
            <ul>
                <li><?php echo __('help.steps.1'); ?></li>
                <li><?php echo __('help.steps.2'); ?></li>
                <li><?php echo __('help.steps.3'); ?></li>
                <li><?php echo __('help.steps.4'); ?></li>
            </ul>
        </div>
    </section>
</main>

<script>
// 언어 문자열을 JavaScript로 전달
const translations = {
    errors: {
        emptyInput: '<?php echo __('errors.empty_input'); ?>',
        sameText: '<?php echo __('errors.same_text'); ?>',
        tooLong: '<?php echo __('errors.too_long'); ?>'
    },
    results: {
        differencesFound: '<?php echo __('results.differences_found'); ?>',
        noDifferences: '<?php echo __('results.no_differences'); ?>',
        identicalTexts: '<?php echo __('results.identical_texts'); ?>',
        added: '<?php echo __('results.added'); ?>',
        removed: '<?php echo __('results.removed'); ?>',
        modified: '<?php echo __('results.modified'); ?>'
    }
};
</script>
<script src="js/text-compare.js"></script>

<?php include 'includes/footer.php'; ?> 
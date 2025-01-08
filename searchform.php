<form
    x-data="baseSearchComponent()"
    role="search"
    method="get"
    class="searchform"
    :class="{ 'searchform--loading': loading }"
    action="<?php echo esc_url(home_url('/')); ?>"
    @click.outside="focused = false;"
    @submit.prevent
>
    <label class="sr-only" for="s"><?php _e('Search for:', 'base'); ?></label>
    <?php echo base_get_inline_svg_icon('search.svg', 'searchform__icon'); ?>
    <input
        x-model="query"
        @input.debounce.500="performSearch()"
        @focus="focused = true"
        type="text"
        class="searchform__control"
        value="<?php echo get_search_query(); ?>"
        name="s"
        placeholder="<?php _e('What are you looking for?', 'base'); ?>"
    >
    <span class="preloader--circle searchform__preloader"></span>
    <div x-cloak class="searchform__results" x-show="focused && searched">
        <div class="searchform__helper">
            <div x-show="results.length > 0" class="searchform__summary" x-text="results.length + ' <?php _e('result(s) found.', 'base'); ?>'"></div>
            <ul x-show="results.length > 0">
                <template x-for="result in results" :key="result.id">
                    <li><a :href="result.url" x-text="result.title"></a></li>
                </template>
            </ul>
            <p
                x-show="results.length == 0"
                class="searchform__no-result"
            >
                <?php _e('No results found.', 'base'); ?>
            </p>
        </div>
    </div>
</form>

<script>
function baseSearchComponent() {
    return {
        query: '',
        results: [],
        searched: false,
        loading: false,
        focused: false,

        async performSearch() {
            this.loading = true;
            if (this.query.length < 3) {
                this.results = [];
                this.loading = false;
                return;
            }

            try {
                const response = await fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>?action=ajax_search&s=' + encodeURIComponent(this.query));
                if (!response.ok) throw new Error('Error fetching search results');

                const data = await response.json();
                this.results = data;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
                this.searched = true;
            }
        }
    }
}
</script>

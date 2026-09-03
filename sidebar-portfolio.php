<aside>
    <div class="archive-links">
        <p>カテゴリー</p>
        <?php
          $categories = get_terms('portfolio-cat');
          if ($categories) :
        ?>
        <ul>
        <?php
        foreach ($categories as $category) {
            echo '<li><a href="/portfolio-cat/' . $category->slug . '/">' . $category->name . '</a></li>';
        }
        ?>
        </ul>
        <?php endif; ?>
    </div>
</aside>
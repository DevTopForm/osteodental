<div class="fieldset js-to-expand opened">
    <div class="fieldset__top">
        <div class="btn fieldset__head  opened">
            <span>{$filter_title}</span>
        </div>
        <div class="fieldset__chosen">
            <span>От {$bounds.from} до {$bounds.to}</span>
        </div>
    </div>
    <div class="fieldset__body">
        <div class="fieldset__body-wrapper">
            <div class="fieldset__body-inside fieldset__body-inside--slider">
                <div id="slider-1" class="fieldset__body-inside js-ui-slider filter-slider">
                    <div class="slider__line" data-slide="slider-slider"></div>
                    <div class="filter-slider__labels">
                        <label class="filter-slider__label">
                            от <input id="difficult_level_min" name="{$filter_name}_from"
                                      class="filter-slider__input" type="number" value="{$bounds.from}"
                                      data-slide="slider-from">
                        </label>
                        <label class="filter-slider__label">
                            до <input id="difficult_level_max" name="{$filter_name}_to"
                                      class="filter-slider__input" type="number" value="{$bounds.to}"
                                      data-slide="slider-to">
                        </label>
                    </div>
                    <input type="hidden" value="{$bounds.from}" name="from_start" data-slide="slider-from-start">
                    <input type="hidden" value="{$bounds.to}" name="to_start" data-slide="slider-to-start">
                </div>
            </div>
        </div>
    </div>
</div>
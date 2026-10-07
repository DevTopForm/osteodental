{if $content}
    <yml_catalog date="{$time}">
        <shop>
            <name>{$params.sitename}</name>
            <company>{$params.sitename}</company>
            <url>https://{$smarty.server.SERVER_NAME}</url>
            <email>{$params.email}</email>
            <picture>https://{$smarty.server.SERVER_NAME}/img/feed-logo.png</picture>
            <description>Каталог врачей</description>
            <currencies>
                <currency id="RUR" rate="1"/>
            </currencies>
            <categories>
                <category id="1">Врач</category>
            </categories>

            {if $branches}
                <sets>
                    {foreach from=$branches item='branch' name='branches'}
                        <set id="{$branch->alias}">
                            <name>
                                {$branch->title}
                            </name>
                            <url>
                                https://{$smarty.server.SERVER_NAME}{$branch->getUrl()}
                            </url>
                        </set>
                    {/foreach}
                </sets>
            {/if}
            <offers>
                {foreach from=$content item='item' name='items'}
                    <offer id="doctor-{$item->id}">
                        <name>{$item->title}</name>
                        <url>https://{$smarty.server.SERVER_NAME}{$item->getUrl()}</url>
                        <price from="true">{$item->price_feed}</price>
                        <currencyId>RUR</currencyId>
                        <sales_notes>Первичный прием</sales_notes>
                        {if $item->branches_alias}
                            <set-ids>{$item->branches_alias}</set-ids>
                        {/if}
                        {if $item->image->id}
                            <picture>https://{$smarty.server.SERVER_NAME}{$item->image->getLink()}</picture>
                        {/if}

                        {if $item->tab_4_text}
                            <description>
                                {$item->tab_4_text}
                            </description>
                        {/if}
                        <categoryId>1</categoryId>
                        {if $item->fio.0}
                            <param name="Фамилия">{$item->fio.0}</param>
                        {/if}

                        {if $item->fio.1}
                            <param name="Имя">{$item->fio.1}</param>
                        {/if}

                        {if $item->fio.2}
                            <param name="Отчество">{$item->fio.2}</param>
                        {/if}

                        {if $item->work_age_number}
                            <param name="Годы опыта">{$item->work_age_number}</param>
                        {/if}
                        <param name="Город">г. Санкт-Петербург</param>
                        {if $item->reviews}
                            <param name="Число отзывов">{$item->reviews|count}</param>
                        {/if}
                        {if $item->science}
                            <param name="Степень">{$item->science}</param>
                        {/if}
                        <param name="Ссылка на профиль врача">https://{$smarty.server.SERVER_NAME}{$item->getUrl()}</param>
                        <param name="Город клиники">г. Санкт-Петербург</param>

                        {if $params.address}
                            <param name="Адрес клиники">{$params.address}</param>
                        {/if}

                        {if $params.sitename}
                            <param name="Название клиники">{$params.sitename}</param>
                        {/if}
                        <param name="Возможность записи">true</param>
                        <param name="Онлайн-расписание">true</param>

                        {if $params.phone}
                            <param name="Телефон для записи">{$params.phone}</param>
                        {/if}

                        {if $item->reviews}
                            {foreach from=$item->reviews item='review' name='reviews'}
                                {if $smarty.foreach.reviews.iteration <= 5}
                                    {if $review->name}
                                        <param name="Отзыв - {$smarty.foreach.reviews.iteration}" unit="Автор">{$review->name}</param>
                                    {/if}
                                    {if $review->date_formatted}
                                        <param name="Отзыв - {$smarty.foreach.reviews.iteration}" unit="Дата">
                                            {$review->date_formated}
                                        </param>
                                    {/if}

                                    <param name="Отзыв - {$smarty.foreach.reviews.iteration}" unit="Отзыв проверен">true</param>

                                    {if $review->text}
                                        <param name="Отзыв - {$smarty.foreach.reviews.iteration}" unit="Комментарий">{$review->text}</param>
                                    {/if}
                                {/if}
                            {/foreach}
                        {/if}
                    </offer>
                {/foreach}
            </offers>
        </shop>
    </yml_catalog>
{/if}
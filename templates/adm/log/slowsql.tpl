{if count($logs)}
    <style>
        table {
            border-collapse: collapse;
        }

        table td {
            padding: 10px;
        }

        table thead {
            font-weight: bold;
            text-align: center;
        }

        table tr td:nth-child(2), table tr td:nth-child(5), table tr td:nth-child(6) {
            text-align: center;
        }

        table tr td:nth-child(3), table tr td:nth-child(4) {
            width: 40%;
        }

        table tr:nth-child(2n) {
            background: #c0bfbf;
        }

        td:nth-child(6) {
            white-space: nowrap;
        }

        form {
            margin: 0 0 20px 10px;
        }

        .select--blue {
            color: var(--white);
            background: var(--blue, #4159d2);
            border-color: var(--blue);
            padding: 7.5px 26px 7.5px 12px;
            min-height: 40px;
            border-radius: 10px;
            border: 1px solid var(--grey_2, #EEE);
        }

        .log-buttons {
            display: flex;
            gap: 50px;
        }

        .log-label {
            display: flex;
            gap: 20px;
            align-items: center;
        }
    </style>

    <div class="board-block" style="margin-bottom: 20px;">
        <form action="" method="GET" enctype="application/x-www-form-urlencoded" class="log-buttons">
            <label class="log-label">
                <span>Поле сортировки</span>
                <select name="sortField" class="select--blue">
                    <option value="time" {if $smarty.get.sortField === "time" || !$smarty.get.sortField} selected {/if}>
                        Время
                    </option>
                    <option value="sql" {if $smarty.get.sortField === "sql"} selected {/if}>Запрос</option>
                    <option value="uri" {if $smarty.get.sortField === "uri"} selected {/if}>Адрес</option>
                    <option value="count" {if $smarty.get.sortField === "count"} selected {/if}>Количество</option>
                    <option value="date" {if $smarty.get.sortField === "date"} selected {/if}>Дата</option>
                </select>
            </label>

            <label class="log-label">
                <span>Порядок сортировки</span>
                <select name="sortOrder" class="select--blue">
                    <option value="desc" {if $smarty.get.sortOrder === "desc" || !$smarty.get.sortOrder} selected {/if}>
                        По убыванию
                    </option>
                    <option value="asc" {if $smarty.get.sortOrder === "asc"} selected {/if}>По возрастанию</option>
                </select>
            </label>

            <button type="submit" class="btn btn--bd btn--lg">Применить</button>

            <a href="/adm/logs/clear/{$item->log->id}" class="btn btn--bd btn--lg" style="margin-left: auto">
                <svg fill="none" width="16" height="16">
                    <use xlink:href="/adm/assets/img/sprite.svg#redo"></use>
                </svg>
                <span>Очистить</span>
            </a>
        </form>

        <table style="max-width: 100%">
            <thead>
            <tr>
                <td>#</td>
                <td>Время (мс)</td>
                <td>Запрос</td>
                <td>Адрес</td>
                <td>Количество</td>
                <td>Дата</td>
            </tr>
            </thead>
            <tbody>
            {foreach $logs as $key => $log}
                <tr>
                    <td>{$key + 1}</td>
                    <td>{$log["time"]}</td>
                    <td style="word-break: break-word;">{$log["sql"]}</td>
                    <td style="word-break: break-word;">{$log["uri"]}</td>
                    <td>{($log["count"]) ?: 1}</td>
                    <td>{nl2br(date("d-m-Y \n H:i:s", $log["date"]))}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
{/if}
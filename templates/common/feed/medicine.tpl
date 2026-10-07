<?xml version="1.0" encoding="UTF-8"?>
<shop version="2.0" date="{$smarty.now|date_format:"%Y-%m-%d %H:%M"}">
    <name>{$feed->params.sitename}</name>
    <company>{$feed->params.sitename}</company>
    <url>{$feed->site_url}</url>


    <doctors>
        {foreach $staff as $doctor}
            <doctor id="doctor_{$doctor->id}">
                <first_name>{$doctor->title[1]}</first_name>
                <surname>{$doctor->title[0]}</surname>
                <patronymic>{$doctor->title[2]}</patronymic>

                {if $doctor->experience}
                    <experience_years>{$doctor->experience}</experience_years>
                {/if}
            </doctor>
        {/foreach}
    </doctors>

    <clinics>
        <clinic id="clinic_1">
            <name>{$feed->params.sitename}</name>
            <address>{$feed->params.address}</address>
            <phone>{$feed->params.phone}</phone>
        </clinic>
    </clinics>

    <services>
        {foreach $services as $service}
            <service id="service_{$service->id}">
                <name>{$service->title}</name>
    {*            <description>Первичный приём стоматолога-хирурга, диагностика</description>*}
            </service>
        {/foreach}
    </services>

    <offers>
        {foreach $services as $service}
            <offer id="offer_{$service->id}">
                <url>{$feed->site_url}{$service->getUrl()}</url>
                <price>
                    <base_price>{$service->item->price}</base_price>
                    <currency>RUR</currency>
                </price>
                <service id="service_{$service->id}"/>
                <clinic id="clinic_1">
                    {foreach $service->item->staff as $doctor}
                        <doctor id="doctor_{$doctor->id}">
                            {if $doctor->position}
                                <speciality>{$doctor->position}</speciality>
                            {/if}

                            <is_base_service>true</is_base_service>
                        </doctor>
                    {/foreach}
                </clinic>
            </offer>
        {/foreach}
    </offers>
</shop>
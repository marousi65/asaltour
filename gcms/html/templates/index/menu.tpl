<!-- menu !-->
                <div class="bg_menu">
                	<div id="myslidemenu" class="jqueryslidemenu">
                        {section name=id loop=$menu_title } 
                     		<ul>
                    		<li><a href="{$menu_url[id]}">{$menu_title[id]}</a>
                            	{if $menu_child_title[id][0]}
                                <ul>
                                {section name=kd loop=$menu_child_title[id]}
                     			<li><a href="{$menu_child_url[id][kd]}">{$menu_child_title[id][kd]}</a></li>
                      			{/section}
                      			</ul>
                                {/if}
                            </li>
                    		</ul>
                            
                       
                        {/section}  
                    <br style="clear: left" />
                    </div>
                </div>
                <!-- menu !-->
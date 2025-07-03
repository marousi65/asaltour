<div class="column leftsb">
            	{include file="index/menu.tpl"}
                
				{if  ( $part eq "page" and $smarty.get.id eq "1" ) or ( $part eq "page" and !$smarty.get.id  )  }
				<div class="column" style="margin-left:10px; margin-top:10px;">
                	<div class="bg_top_box1">
                    	<div class="title">{$gcms_1_title}</div>
                    </div>
                	<div class="bg_mid_box1">
                    	<div class="txt">
						{if $gcms_1_pic neq "/gcms/upload/title-images/defultpagepic.jpg" }
						<img src="{$gcms_1_pic}"  class="left" />
						{/if}
                        {$gcms_1_content}
                        <div class="clear"></div>
						</div>
                    </div>
                	<div class="bg_dwn_box1"></div>
                </div>
				<!-- !-->
              	<!-- !-->
				<div class="column" style=" margin-top:10px;">
                	<div class="bg_top_box1">
                    	<div class="title">{$gcms_2_title}</div>
                    </div>
                	<div class="bg_mid_box1">
                    	<div class="txt">
						{if $gcms_2_pic neq "/gcms/upload/title-images/defultpagepic.jpg" }
						<img src="{$gcms_2_pic}"  class="left" />
						{/if}
                        {$gcms_2_content}
                        <div class="clear"></div>
						</div>
                    </div>
                	<div class="bg_dwn_box1"></div>
                </div>
				<!-- !-->
                <div class="clear"></div>
				
				<div class="header" style="background:url({$gcms_4_pic}) no-repeat ;"style="background:url({$gcms_4_pic}) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
                {if $part eq "page" and $smarty.get.id}
               <div class="bg_top_box2">
					<div class="title">{$page_title}</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
					{if $page_pic neq "/gcms/upload/title-images/defultpagepic.jpg" }
					<img src="{$page_pic}"  class="left" />
					{/if}
                    {$page_content}
                    <div class="clear"></div>
					{if $childlist_title }
                        {section name=id loop=$childlist_title } 
                        <div class="child_page">
                        
                        <img src="{$childlist_pic[id]}"  width="10%" height="10%" class="left" title="{$childlist_title[id]}"/>
                        <b><a href="{$childlist_url[id]}" >
                        {$childlist_title[id]}
                        </a></b><br />
                        {$childlist_excerpt[id]}<br />
                        <div style="text-align:left">
                        <a href="{$childlist_url[id]}">ادامه مطلب&hellip;</a>
                        </div>
                        <div class="clear"></div>
                        </div>
                       
                        {/section}  
            
            
             <div id="dpage" >{$page}</div>
                   {/if} 
				 
					<div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
                {/if}
				{/if}
				{if $part eq "page" and $smarty.get.id neq "1"   }
				{if  !$smarty.get.id }
				<script language="JavaScript">setTimeout("top.location.href = '?part=page&id=1	'",0);</script>
				{/if}
				<div class="header" style="background:url({$gcms_4_pic}) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title">{$page_title}</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
					{if $page_pic neq "/gcms/upload/title-images/defultpagepic.jpg" }
					<img src="{$page_pic}"  class="left" />
					{/if}
                    {$page_content}
                    <div class="clear"></div>
                    
					{if $childlist_title }
                        {section name=id loop=$childlist_title } 
                        <div class="child_page">
                        {if $childlist_pic[id] neq "/gcms/upload/title-images/defultpagepic.jpg" }
                        <img src="{$childlist_pic[id]}"  width="10%" height="10%" class="left" title="{$childlist_title[id]}"/>
						{/if}
                        <b><a href="{$childlist_url[id]}" >
                        {$childlist_title[id]}
                        </a></b><br />
                        {$childlist_excerpt[id]}<br />
                        <div style="text-align:left">
                        <a href="{$childlist_url[id]}">ادامه مطلب&hellip;</a>
                        </div>
                        <div class="clear"></div>
                        </div>
                       
                        {/section}  
            
            
             <div id="dpage" >{$page}</div>
                   {/if}
				 
					<div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
                {/if}
				{if $part eq "signin"   }
				
				<div class="header" style="background:url({$gcms_4_pic}) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title">{$page_title}</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    <div class="error">{$error_message}</div>
					<br /><br /><br /><br /><br /><br /><br /><br /><br />
                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				{/if}
				{if $part eq "admin"   }
				
				<div class="header" style="background:url({$gcms_4_pic}) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title">{$page_title}</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    {if $error_message}<div class="error">{$error_message}</div>{/if}
                    {if $success_message}<div class="success">{$success_message}</div>{/if}
					{$admin_content}
                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				{/if}
                
				{if $part eq "shipman"   }
				
				<div class="header" style="background:url({$gcms_4_pic}) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title">{$page_title}</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    {if $error_message}<div class="error">{$error_message}</div>{/if}
                    {if $success_message}<div class="success">{$success_message}</div>{/if}
					{$shipman_content}
                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				{/if}
                
								{if $part eq "portman"   }
				
				<div class="header" style="background:url({$gcms_4_pic}) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title">{$page_title}</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    {if $error_message}<div class="error">{$error_message}</div>{/if}
                    {if $success_message}<div class="success">{$success_message}</div>{/if}
					{$portman_content}
                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				{/if}
                
								{if $part eq "free"   }
				
				<div class="header" style="background:url({$gcms_4_pic}) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title">{$page_title}</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    {if $error_message}<div class="error">{$error_message}</div>{/if}
                    {if $success_message}<div class="success">{$success_message}</div>{/if}
					{$free_content}
                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				{/if}
                
				{if $part eq "agency"   }
				
				<div class="header" style="background:url({$gcms_4_pic}) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title">{$page_title}</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    {if $error_message}<div class="error">{$error_message}</div>{/if}
                    {if $success_message}<div class="success">{$success_message}</div>{/if}
					{$agency_content}
                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				{/if}
                
				{if $part eq "signup"   }
				
				<div class="header" style="background:url({$gcms_4_pic}) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title">{$page_title}</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    {if $error_message}<div class="error">{$error_message}</div>{/if}
                    {if $success_message}<div class="success">{$success_message}</div>{/if}
					{$signup_content}
                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				{/if}
                
                
				{if $part eq "forgotten"   }
				
				<div class="header" style="background:url({$gcms_4_pic}) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title">{$page_title}</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    {if $error_message}<div class="error">{$error_message}</div>{/if}
                    {if $success_message}<div class="success">{$success_message}</div>{/if}
					{$forgotten_content}
                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				{/if}
                
                
				{if $part eq "searchtrade"   }
				
				<div class="header" style="background:url({$gcms_4_pic}) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title">جستجو</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    {if $error_message}<div class="error">{$error_message}</div>{/if}
                    {if $success_message}<div class="success">{$success_message}</div>{/if}
					{$searchtrade_content}
                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2" style="margin-top:-5px" ></div>
				 <!-- !-->
				{/if}
                
                
				{if $part eq "buy"   }
				
				<div class="header" style="background:url({$gcms_4_pic}) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title">{$page_title}</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    {if $error_message}<div class="error">{$error_message}</div>{/if}
                    {if $success_message}<div class="success">{$success_message}</div>{/if}
					{$buy_content}
                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				{/if}
            </div>

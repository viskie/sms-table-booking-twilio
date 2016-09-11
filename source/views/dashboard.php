<!-- Content -->
					<div id="content" class="clearfix">
                        
                        <!-- Sidebar -->
                        <div id="side-content-right">
                            
                         
                            
                            <!-- Search box -->
                            <h3>Search</h3>
                            <div class="body-con">
                                <form action="javascript: void(0)" method="post" id="search-form" name="search-form" class="pos-rel">
                                    <input type="text" id="search-keyword" name="search-keyword" value="Search.." onfocus="this.value = '';" class="search" />
                                    <input type="submit" value="Go" id="search-btn" name="search-btn" class="grey search" />
                                </form>
                            </div>
                            <!-- END Search box -->
                            
                            <!-- Updates & Notifications -->
                            
                            <!-- Sidebar tabs -->
                            <ul id="s-tabs" class="content-tabs clearfix">
                                <li class="active"><a href="#s-updates">Updates</a></li>
                                <li><a href="#s-notifications">Notifications</a></li>
                            </ul>
                            <!-- END Sidebar tabs -->

                            <div class="body-con">
                           

                            </div>
                            <!-- END Updates & Notifications -->
                            
                     
                        
                        
                            
                        </div>
                        <!-- END Sidebar -->
                        
                        <!-- Main Content -->
                        <div id="main-content-left">
                     
                            <!-- Statistics example with Flot plugin -->
                            <h2>Statistics (Visits)</h2>

                            <div class="body-con">
                                <div id="flot-custom" class="flot-con"></div>
                            </div>
                            <!-- END Statistics example with Flot plugin -->

                           
                            
                        </div>
                        <!-- END Main Content -->
                        
					</div>
					<!-- END Content -->
<script>            
            $(function(){
                /* Initialize Flot */
                // for advanced usage and customization you can check out the documentation and examples at http://code.google.com/p/flot/
                var d1 = [ [1, 3400], [2, 14000], [3, 30000], [4, 35000], [5, 29000], [6, 58000], [7, 75000],
                        [8, 82000], [9, 92000], [10, 100000], [11, 125000], [12, 134000] ]

                // Visits statistics
                $.plot($("#flot-custom"), [
                    {
                        data: d1,
                        lines: {show: true, fillColor: '#FFFFFF', fill: 1},
                        points: {show: true}
                    }
                ], {
                    xaxis: {
                        ticks: [[1, "Jan"], [2, "Feb"], [3, "Mar"], [4, "Apr"], [5, "May"], [6, "Jun"], [7, "Jul"],
                                   [8, "Aug"], [9, "Sep"], [10, "Oct"], [11, "Nov"], [12, "Dec"]]
                    },
                    yaxis: {
                        ticks: 10,
                        min: 0
                    },
                    grid: {
                        backgroundColor: {colors: ["#FFFFFF", "#EEEEEE"]}
                    }
                });
                
            })
        </script>
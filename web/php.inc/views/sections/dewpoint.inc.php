                        <div class="tile bg-purple">
                            <div class="collumn-left">
                                <i class="wi wi-raindrop"></i>
                            </div>
                            <div class="collumn-right">
                                <h5><?= $dashboard->dewpoint; ?></h5>
                                <h2>
                                <?php if (isset($dashboard->data['dewpoint'])): echo $dashboard->data['dewpoint'] ?><i class="wi wi-celsius"></i>
                                <?php else: ?><i class="wi wi-na"></i>
                                <?php endif; ?>
                                </h2>
                            </div>
                        </div>
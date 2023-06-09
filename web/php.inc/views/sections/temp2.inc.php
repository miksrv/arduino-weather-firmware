                        <div class="tile bg-red">
                            <a href="<?= DIR_ROOT ?>statistics/#chart1" title="<?= $language->graphics; ?> - <?= $dashboard->temp2; ?>">
                                <div class="collumn-left">
                                    <i class="wi wi-thermometer-exterior"></i>
                                </div>
                                <div class="collumn-right">
                                    <h5><?= $dashboard->temp2; ?></h5>
                                    <h2>
                                    <?php if (isset($dashboard->data['temp2'])): echo $dashboard->data['signs']['temp2'] . $dashboard->data['temp2'] ?><i class="wi wi-celsius"></i>
                                    <?php else: ?><i class="wi wi-na"></i>
                                    <?php endif; ?>
                                    </h2>
                                </div>
                            </a>
                        </div>
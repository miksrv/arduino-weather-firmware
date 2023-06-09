                        <div class="tile bg-red">
                            <a href="<?= DIR_ROOT ?>statistics/#chart1" title="<?= $language->graphics; ?> - <?= $dashboard->temp1; ?>">
                                <div class="collumn-left">
                                    <i class="wi wi-thermometer"></i>
                                </div>
                                <div class="collumn-right">
                                    <h5><?= $dashboard->temp1; ?></h5>
                                    <h2>
                                    <?php if (isset($dashboard->data['temp1'])): echo $dashboard->data['signs']['temp1'] . $dashboard->data['temp1'] ?><i class="wi wi-celsius"></i>
                                    <?php else: ?><i class="wi wi-na"></i>
                                    <?php endif; ?>
                                    </h2>
                                </div>
                            </a>
                        </div>
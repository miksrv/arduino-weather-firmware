                        <div class="tile bg-pink">
                            <a href="<?= DIR_ROOT ?>statistics/#chart2" title="<?= $language->graphics; ?> - <?= $dashboard->wind; ?>">
                                <div class="collumn-left">
                                    <i class="wi wi-strong-wind"></i>
                                </div>
                                <div class="collumn-right">
                                    <h5><?= $dashboard->wind; ?></h5>
                                    <h2>
                                    <?php if (isset($dashboard->data['wind'])): echo $dashboard->data['signs']['wind'] . $dashboard->data['wind'] ?>
                                    <?php else: ?><i class="wi wi-na"></i>
                                    <?php endif; ?>
                                    </h2>
                                </div>
                            </a>
                        </div>
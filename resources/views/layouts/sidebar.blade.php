<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('dashboard') }}" class="b-brand d-flex align-items-center">
                <img 
                    src="{{ asset('assets/images/HORIZON-BLUE.png') }}" 
                    alt="Inventory Roda 3"
                    style="height:36px"
                >
            </a>
        </div>

        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="{{ route('dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Master Data</label>
                </li>

               <li class="pc-item pc-hasmenu">
                    <a href="javascript:void(0)" class="pc-link">
                        <span class="pc-micon">
                            <i class="ti ti-tools"></i>
                        </span>
                        <span class="pc-mtext">Sparepart</span>
                        <span class="pc-arrow"></span>
                    </a>

                    {{-- ⬇️ INI WAJIB ADA --}}
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a href="{{ route('sparepart.index') }}" class="pc-link">
                                Data Sparepart
                            </a>
                        </li>

                        <li class="pc-item">
                            <a href="{{ route('sparepart.masuk.index') }}" class="pc-link">
                                Data Masuk
                            </a>
                        </li>

                        <li class="pc-item">
                            <a href="{{ route('sparepart.keluar.index') }}" class="pc-link">
                                Data Keluar
                            </a>
                        </li>

                        <li class="pc-item">
                            <a href="{{ route('sparepart.riwayat.index') }}" class="pc-link">
                                Riwayat Sparepart
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="pc-item pc-hasmenu">
                    <a href="javascript:void(0)" class="pc-link">
                        <span class="pc-micon">
                            <i class="ti ti-truck"></i>
                        </span>
                        <span class="pc-mtext">Unit Roda 3</span>
                        <span class="pc-arrow"></span>
                    </a>

                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a href="{{ route('unit.index') }}" class="pc-link">
                                Data Unit
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('unit.create') }}" class="pc-link">
                                Tambah Unit
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('unit.bulk-status') }}" class="pc-link">
                                Edit Status Unit
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="pc-item pc-caption">
                    <label>Transaksi</label>
                </li>

                {{-- INQUIRY --}}
                <li class="pc-item pc-hasmenu">
                    <a href="javascript:void(0)" class="pc-link">
                        <span class="pc-micon">
                            <i class="ti ti-file-search"></i>
                        </span>
                        <span class="pc-mtext">Inquiry</span>
                        <span class="pc-arrow"></span>
                    </a>

                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a href="{{ route('inquiry.index') }}" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-list"></i>
                                </span>
                                <span class="pc-mtext">Data Inquiry</span>
                            </a>
                        </li>

                        <li class="pc-item">
                            <a href="{{ route('inquiry.create') }}" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-plus"></i>
                                </span>
                                <span class="pc-mtext">Buat Inquiry</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- INVOICE --}}
                <li class="pc-item pc-hasmenu">
                    <a href="javascript:void(0)" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-file-invoice"></i></span>
                        <span class="pc-mtext">Invoice</span>
                        <span class="pc-arrow"></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a href="{{ route('invoice.index') }}" class="pc-link">
                                Data Invoice
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('invoice.select-inquiry') }}" class="pc-link">
                                Buat Invoice
                            </a>
                        </li>
                    </ul>
                </li>


               

                <li class="pc-item">
                    <a href="#" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-arrow-up"></i></span>
                        <span class="pc-mtext">Barang Keluar</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Laporan</label>
                </li>

                <li class="pc-item">
                    <a href="#" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-file-report"></i></span>
                        <span class="pc-mtext">Laporan Stok</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

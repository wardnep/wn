import React, { useState, useMemo } from 'react';

const PositionSizing = () => {
    const [riskUsd, setRiskUsd] = useState('');
    const [entryPrice, setEntryPrice] = useState('');
    const [slUsd, setSlUsd] = useState('');
    const [balance, setBalance] = useState('');

    const MAX_LEVERAGE = 100; // Binance XAUUSDT perpetual max leverage
    const MIN_NOTIONAL = 5;   // Binance minimum notional (~5 USDT)

    const result = useMemo(() => {
        const r = parseFloat(riskUsd);
        const p = parseFloat(entryPrice);
        const s = parseFloat(slUsd);
        const b = parseFloat(balance);

        if (!r || !p || !s || r <= 0 || p <= 0 || s <= 0) return null;

        // Binance XAUUSDT: 1 contract unit = 1 oz of gold
        const qty = r / s;
        const notional = qty * p;

        let minLeverage = null;
        let marginRequired = null;
        let exceedsMax = false;

        if (b && b > 0) {
            minLeverage = Math.ceil(notional / b);
            if (minLeverage > MAX_LEVERAGE) {
                exceedsMax = true;
                minLeverage = MAX_LEVERAGE;
            }
            marginRequired = notional / minLeverage;
        }

        const belowMinNotional = notional < MIN_NOTIONAL;

        return { qty, notional, minLeverage, marginRequired, exceedsMax, belowMinNotional };
    }, [riskUsd, entryPrice, slUsd, balance]);

    const leverageOptions = [5, 10, 20, 25, 50, 75, 100];

    return (
        <div className="card card-primary card-outline ps-card">
            {/* สีแถว OK / ไม่พอ สำหรับ dark theme (พื้นโปร่ง + ตัวหนังสือสว่าง) */}
            <style>{`
                .ps-ok,
                .ps-ok > th,
                .ps-ok > td {
                    background-color: rgba(74, 222, 128, 0.18) !important;
                    color: #86efac !important;
                }
                .ps-bad,
                .ps-bad > th,
                .ps-bad > td {
                    background-color: rgba(248, 113, 113, 0.18) !important;
                    color: #fca5a5 !important;
                }
                .ps-card { width: 100%; overflow: hidden; border: 1px solid #374151; border-radius: .75rem; background: #1f2937; color: #e5e7eb; }
                .ps-card .card-header { padding: 1rem 1.25rem; border-bottom: 1px solid #374151; }
                .ps-card .card-title { margin: 0; font-size: 1.1rem; font-weight: 600; }
                .ps-card .card-body { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 1.5rem; padding: 1.25rem; }
                .ps-inputs { display: flex; flex-direction: column; gap: 1rem; }
                .ps-inputs .form-group { margin: 0; }
                .ps-inputs label { display: block; margin-bottom: .35rem; font-size: .9rem; font-weight: 600; }
                .ps-inputs .input-group { display: flex; }
                .ps-inputs .input-group-text { display: flex; align-items: center; padding: 0 .75rem; border: 1px solid #4b5563; border-right: 0; border-radius: .5rem 0 0 .5rem; background: #374151; }
                .ps-inputs .form-control { min-width: 0; border-radius: 0 .5rem .5rem 0; }
                .ps-results { min-width: 0; }
                .ps-results .table { margin: 0; }
                .ps-results .result-note { margin-top: .75rem; font-size: .85rem; color: #d1d5db; }
                .ps-empty { display: flex; min-height: 12rem; align-items: center; justify-content: center; border: 1px dashed #4b5563; border-radius: .5rem; padding: 1.5rem; color: #9ca3af; text-align: center; }
                .ps-card .alert { border-radius: .5rem; background: #78350f; padding: .5rem .75rem; color: #fde68a; }
                @media (max-width: 767px) { .ps-card .card-body { grid-template-columns: minmax(0, 1fr); } .ps-empty { min-height: 6rem; } }
            `}</style>

            <div className="card-header">
                <h3 className="card-title">
                    <i className="fas fa-calculator mr-1" />
                    Position Sizing — Crypto Futures Market
                </h3>
            </div>

            <div className="card-body">
                <div className="ps-inputs">
                <div className="form-group">
                    <label>Risk ($)</label>
                    <div className="input-group">
                        <div className="input-group-prepend">
                            <span className="input-group-text">$</span>
                        </div>
                        <input
                            type="number"
                            className="form-control"
                            placeholder=""
                            value={riskUsd}
                            onChange={(e) => setRiskUsd(e.target.value)}
                        />
                    </div>
                </div>

                <div className="form-group">
                    <label>Entry Price</label>
                    <div className="input-group">
                        <div className="input-group-prepend">
                            <span className="input-group-text">$</span>
                        </div>
                        <input
                            type="number"
                            className="form-control"
                            placeholder=""
                            value={entryPrice}
                            onChange={(e) => setEntryPrice(e.target.value)}
                        />
                    </div>
                </div>

                <div className="form-group">
                    <label>Stop Loss ($) — distance from entry</label>
                    <div className="input-group">
                        <div className="input-group-prepend">
                            <span className="input-group-text">$</span>
                        </div>
                        <input
                            type="number"
                            className="form-control"
                            placeholder=""
                            value={slUsd}
                            onChange={(e) => setSlUsd(e.target.value)}
                        />
                    </div>
                </div>

                <div className="form-group">
                    <label>Account Balance — for minimum leverage calc</label>
                    <div className="input-group">
                        <div className="input-group-prepend">
                            <span className="input-group-text">$</span>
                        </div>
                        <input
                            type="number"
                            className="form-control"
                            placeholder=""
                            value={balance}
                            onChange={(e) => setBalance(e.target.value)}
                        />
                    </div>
                </div>
                </div>

                <div className="ps-results">
                {result ? (
                    <div>
                        <table className="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <th style={{ width: '50%' }}>Position Size</th>
                                    <td>{result.qty.toFixed(4)}</td>
                                </tr>
                                <tr>
                                    <th>Notional Value</th>
                                    <td>${result.notional.toFixed(2)}</td>
                                </tr>
                                {result.minLeverage && (
                                    <>
                                        <tr className={result.exceedsMax ? 'ps-bad' : 'ps-ok'}>
                                            <th>Minimum Leverage Required</th>
                                            <td>
                                                {result.exceedsMax
                                                    ? `Exceeds max (${MAX_LEVERAGE}x) — balance too low for this risk`
                                                    : `${result.minLeverage}x`}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Margin Required</th>
                                            <td>${result.marginRequired.toFixed(2)}</td>
                                        </tr>
                                    </>
                                )}
                            </tbody>
                        </table>

                        {!balance && (
                            <div className="alert alert-warning py-1 px-2 small mb-0">
                                Enter "Account Balance" to calculate minimum leverage
                            </div>
                        )}

                        {result.belowMinNotional && (
                            <div className="alert alert-warning py-1 px-2 small mt-2 mb-0">
                                Notional value is below Binance's minimum (~${MIN_NOTIONAL}) — this order may not be allowed
                            </div>
                        )}

                        {result.exceedsMax && (
                            <div className="alert alert-warning py-1 px-2 small mt-2 mb-0">
                                The required leverage exceeds the available maximum of {MAX_LEVERAGE}x.
                            </div>
                        )}

                        {result.minLeverage && (
                            <div className="mt-2">
                                <small className="text-muted">Compared to available leverage tiers (max {MAX_LEVERAGE}x):</small>
                                <table className="table table-sm table-striped mt-1">
                                    <thead>
                                        <tr>
                                            <th>Leverage</th>
                                            <th>Margin Required</th>
                                            <th>Sufficient?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {leverageOptions.map((lev) => {
                                            const margin = result.notional / lev;
                                            const b = parseFloat(balance);
                                            const ok = b && margin <= b;
                                            return (
                                                <tr key={lev} className={ok ? 'ps-ok' : ''}>
                                                    <td>{lev}x</td>
                                                    <td>${margin.toFixed(2)}</td>
                                                    <td>{ok ? '✓' : '✗'}</td>
                                                </tr>
                                            );
                                        })}
                                    </tbody>
                                </table>
                            </div>
                        )}
                    </div>
                ) : (
                    <div className="ps-empty">กรอก Risk, Entry Price และ Stop Loss เพื่อดูขนาด Position และ Margin ที่ต้องใช้</div>
                )}
                </div>
            </div>
        </div>
    );
};

export default PositionSizing;

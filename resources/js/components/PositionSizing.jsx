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
        <div className="card card-primary card-outline">
            <div className="card-header">
                <h3 className="card-title">
                    <i className="fas fa-calculator mr-1" />
                    Position Sizing — Binance Futures - claude.ai (Sonnet 5)
                </h3>
            </div>

            <div className="card-body">
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

                {result && (
                    <div className="mt-4">
                        <table className="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <th style={{ width: '50%' }}>Position Size (XAU / oz)</th>
                                    <td>{result.qty.toFixed(4)}</td>
                                </tr>
                                <tr>
                                    <th>Notional Value</th>
                                    <td>${result.notional.toFixed(2)}</td>
                                </tr>
                                {result.minLeverage && (
                                    <>
                                        <tr className={result.exceedsMax ? 'table-danger' : 'table-success'}>
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
                                                <tr key={lev} className={ok ? 'table-success' : ''}>
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
                )}
            </div>
        </div>
    );
};

export default PositionSizing;

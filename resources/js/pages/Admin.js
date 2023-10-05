import React, { useState, useEffect } from 'react';
import {useCookies} from 'react-cookie';
import Points from '../components/Points';
import Total from '../components/Total';
import SendInvite from '../components/SendInvite';
import Navbar from "../components/Navbar";

import axios from "axios";

function Admin() {
  const [cookies, setCookie, removeCookie] = useCookies(['token']);
  const [total, setTotal] = useState(0);
  const [currentTotal, setCurrentTotal] = useState(0);
  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [referrals, setReferrals] = useState([]);
  const [referrerId, setReferrerId] = useState(cookies.user_id);

  const fetchReferrals = (page) => {
    let axiosHeaders = {
      'Authorization': `Bearer ${cookies.token}`
    };
    axios.get(`/api/referrals?page=${page}`, {
      headers: axiosHeaders
    }).then(result => {
        setReferrals(result.data.data);
        setTotal(result.data.meta.total);
        setCurrentPage(result.data.meta.current_page);
        setLastPage(result.data.meta.last_page);
        setCurrentTotal(result.data.meta.to);
        if (result.data.meta.total > 0) {
          setReferrerId(result.data.data[0].referrer.id);
        }
      })
      .catch(error =>  {
      })
  }

  useEffect(() => {
    fetchReferrals(1);
  }, []);

  const handleOnClickPrevious = () => {
    fetchReferrals(currentPage - 1);
  }

  const handleOnClickNext = () => {
    fetchReferrals(currentPage + 1);
  }

  return (
    <>
      <Navbar />
      <div className="container py-5">
        <div className="row mt-3 pb-5">
          <div className="row pb-5">
            <Points />
            <Total total={total} />
          </div>
          <div className="col-12">
            <div className="d-flex justify-content-between">
              <h1 className="font-weight-bold">All Referrals</h1>
              <SendInvite referrerId={referrerId} fetchReferrals={fetchReferrals}/>
            </div>
          </div>
          <div className="col-12 pt-5">
              <table className="table table-hover">
              <thead>
                  <tr>
                  <th scope="col">#</th>
                  <th scope="col">Referrer</th>
                  <th scope="col">Email Invited</th>
                  <th scope="col">Invited At</th>
                  <th scope="col">Status</th>
                  </tr>
              </thead>
              <tbody>
                  { referrals ? 
                  referrals.map( (referral, index) => (
                      <tr key={`${index}-${referral.id}`}>
                      <th scope="row">{ referral.id }</th>
                      <td>
                        <p className="mb-0">{ referral.referrer.name }</p>
                        <span className="text-muted">{ referral.referrer.email }</span>
                      </td>
                      <td>{ referral.email }</td>
                      <td>{ referral.created_at }</td>
                      <td><span className={ referral.status === 'invited' ? 'badge bg-secondary' : 'badge bg-success' }>{ referral.status }</span></td>
                      </tr>
                  )) : ''
                  }
                  <tr>
                  </tr>
              </tbody>
              </table>
          </div>
      </div>
      <div className="row">
          <div className="col-6">
          <p>Showing {currentTotal} out of {total} records</p>
          </div>

          <div className="col-6">
              <nav>
                  <ul className="pagination justify-content-end">
                  <li className="page-item disabled">
                      <button className="btn btn-secondary rounded-0" onClick={ handleOnClickPrevious } disabled={currentPage == 1 ? 'disabled' : ''} >Previous</button>
                  </li>
                  <li className="page-item">
                      <button className="btn btn-success rounded-0" onClick={ handleOnClickNext } disabled={lastPage == currentPage ? 'disabled' : ''}>Next</button>
                  </li>
                  </ul>
              </nav>
          </div>
      </div>
      </div>
    </>
    );
}
export default Admin;
import React, { useState, useEffect } from 'react';
import {useCookies} from 'react-cookie';
import MultipleValueTextInput from 'react-multivalue-text-input';
import axios from "axios";

const SendInvite = ({fetchReferrals}) => {
  const [cookies, setCookie, removeCookie] = useCookies(['token']);
  const [showSendInviteModal, setShowSendInviteModal] = useState(false);
  const [emails, setEmails] = useState([]);
  const [loading, setLoading] = useState(false);
  const [isDisable, setIsDisable] = useState(false);
  const [error, setError] = useState(false);
  const [message, setMessage] = useState([]);

  const handleOnClickSendInvite = () => {
    setShowSendInviteModal(!showSendInviteModal);
  }

  const handleOnChangeEmails = (list) => {
    setEmails(list);
  }

  const handleOnSubmitSendInvite = () => {
    setLoading(true);
    setIsDisable(true);
    let axiosHeaders = {
      'Authorization': `Bearer ${cookies.token}`
    };
    let referrals = {
      emails,
      referrer_id: cookies.user_id,
    };
    axios.post('/api/referrals/invite', referrals, {
      headers: axiosHeaders
    })
      .then(result => {
        setEmails([]);
        setShowSendInviteModal(false);
        fetchReferrals();
        setLoading(false);
        setIsDisable(false);
        setError(false);
        setMessage('');
      })
      .catch(error =>  {
        let errors = error.response.data.errors;
        let apiErrors = [];
        Object.values(errors).map((errorMessage) => {
          errorMessage.map((err) => {
            apiErrors = [...apiErrors, err];
          })
        }); 
        setMessage(apiErrors);
        setError(true);
        setLoading(false);
        setIsDisable(false);
      })
  }
  
  return (
    <>
      <button type="button" className="btn btn-primary rounded-0" onClick={ handleOnClickSendInvite }>
        Send Invite
      </button>
      { showSendInviteModal && (
      <div className="modal d-block bg-secondary">
        <div className="modal-dialog modal-dialog-centered">
          <div className="modal-content">
            <div className="modal-header">
              <h5 className="modal-title">Send Your Referrals</h5>
              <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close" disabled={isDisable ? 'disabled' : ''}  onClick={ () => {setShowSendInviteModal(false);} }></button>
            </div>
            <div className="modal-body">
              <MultipleValueTextInput
                onItemAdded={(item, allItems) => handleOnChangeEmails(allItems)}
                onItemDeleted={(item, allItems) => handleOnChangeEmails(allItems)}
                label=""
                name="item-input"
                placeholder="Press enter to submit email addresses"
                className="form-control"
              />
              {
                error && (
                  <>
                    <p className="text-danger py-2 mt-2">Failed: </p>
                    <p className="bg-light p-2 border-1 border-danger">{ JSON.stringify(message) }</p>
                  </>
                )
              }
            </div>
            <div className="modal-footer">
              <button type="button" className="btn btn-secondary" data-bs-dismiss="modal" disabled={isDisable ? 'disabled' : ''} onClick={ () => {setShowSendInviteModal(false);} }>Close</button>
              <button type="button" onClick={handleOnSubmitSendInvite} disabled={isDisable ? 'disabled' : ''} className="btn btn-primary">{ loading ? 'Sending...' : 'Send Invitation'}</button>
            </div>
          </div>
        </div>
      </div>)}
    </> 
  );
}
export default SendInvite;
import React, { Component } from 'react';

export class SignUp extends Component {
  static displayName = SignUp.name;

  constructor(props) {
    super(props);
    this.state = { email:'', password:'', passwordConfirm:'', data:[], isLoading: true };
    this.handleChange = this.handleChange.bind(this);
  }

  handleSubmit = (e) => {
    const data = { email:this.state.email, password:this.state.password, passwordConfirm:this.state.passwordConfirm  };

    if(data.password !== data.passwordConfirm){
      alert("Your password and confirmation password do not match.");
      return;
    }

    fetch('api/customer/signup',{method: 'POST', headers: {'Accept': 'application/json', 'Content-Type': 'application/json'}, body: JSON.stringify(data)})
      .then(response => response.json())
      .then(data => {
        this.setState({ data: data, isLoading: false });
        console.log(data);
 
        if(data.result === "success") this.props.history.push('/');
        else alert(data.message);
      }) 
      .catch(error => this.setState({ error, isLoading: false }));
    e.preventDefault();
  }  

  handleChange(e){
    this.setState({ [e.target.name]:e.target.value })
  }  

  render() {
    return (
      <div className="text-center">
        <h1>SignUp</h1>
        <form className="form-signin" onSubmit={this.handleSubmit}>
            <img src="/img/icon/googsu.png" alt="Googsu.com SignUp" /> 
            <hr/>
            <label htmlFor="inputEmail" className="sr-only">Email address</label>
            <input type="email" id="inputEmail" className="form-control" placeholder="Email address" required="required" autoFocus="autoFocus" name="email" onChange={this.handleChange}/>

            <label htmlFor="inputPassword" className="sr-only">Password</label>
            <input type="password" id="inputPassword" className="form-control" placeholder="Password" required="required" name="password" onChange={this.handleChange}/>

            <label htmlFor="inputPasswordConfirm" className="sr-only">Password Confirm</label>
            <input type="password" id="inputPasswordConfirm" className="form-control" placeholder="Password Confirm" required="required" name="passwordConfirm" onChange={this.handleChange}/>            

          <button className="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
        </form>
      </div>
    );
  }
}


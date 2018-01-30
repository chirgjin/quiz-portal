import React, { Component } from 'react';
import 'bootstrap/dist/css/bootstrap.css';
import './../css/Login.css';

class Login extends Component {
	constructor(props){
		super(props);
		this.state = {
			teamStatus : 'false',
			credential1 : '',
			credential2 : '',
			loginStatus : "false",	
			particapationType1 : "",
			particapationType2 : "",
			hidden : 'hidden',
			selectParticipationType : 'selectParticipationType',
			inputType : '',
			response : null
		}
	}

	loner(){
		let detail1 = 'Enter Email';
		let detail2 = 'Enter Phone Number';
		console.log("loner");
		this.setState({
			particapationType1 : detail1,
			particapationType2 : detail2,
			hidden : 'credentials',
			selectParticipationType : 'hidden',
			inputType : 'email'
		});
		
	}
	team(){
		let detail1 = 'Enter Team Name';
		let detail2 = 'Enter Code';
		console.log("Team");
		this.setState({
			teamStatus : 'true',
			particapationType1 : detail1,
			particapationType2 : detail2,
			hidden : 'credentials',
			selectParticipationType : 'hidden',
			inputType : 'text'
		});
	}
	handelCredential1Change({target}){
		this.setState({
			credential1:target.value
		})
	}
	handelCredential2Change({target}){
		this.setState({
			credential2:target.value
		})
	}
	Submit(){
		let data;
		localStorage.setItem('credential1', this.state.credential1);
		localStorage.setItem('credential2', this.state.credential2);
		console.log('submit')
		console.log(`credential1 = ${this.state.credential1}`);
		console.log(`credential2 = ${this.state.credential2}`);
		if(this.state.teamStatus === 'false'){
			data = {
				isTeam : this.state.teamStatus,
				email : this.state.credential1,
				phone : this.state.credential2
			}
		}else{
			data = {
				isTeam : this.state.teamStatus,
				teamName : this.state.credential1,
				teamCode : this.state.credential2
			}
		}
		let base_url = 'http://quizportal.cf/backend/login.php';
		console.log(data.isTeam);
		fetch(base_url, {
			method: 'POST',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json',
			},
			credentials : 'include',
			body : JSON.stringify(data)
		}).then(res => res.json())
		.then((json) => {
			console.log(json);
			this.setState({response:json});
				console.log(this.state.response.success)
				localStorage.setItem('response', JSON.stringify(json));
				if(this.state.response.success === 1){
					console.log('comming')
					window.location.href = 'http://localhost:3000/dashboard'
				}
		})
		.catch(err => console.log(err));
	}
	preventDefault(event) {
		event.preventDefault();
		return false;
	};
  render() {
	// console.log(this.state.loner_status);
	// console.log(this.state.team_status);
    return (
                <div className="row">
			<div className="col-3 form_details">
				<div className= {this.state.selectParticipationType}>
				<img className="logo-login" src={require('../img/quizapp.jpg')} alt=""/>
					<div className="vertical-align">
						<button onClick={this.loner.bind(this)}  className = 'loner_type'>Loner Register</button><br/><br/>
						<button onClick={this.team.bind(this)}  className = 'team_type'>Team Register</button>
					</div>
				</div>
				<div className = {this.state.hidden}>
				<img className="logo-login" src={require('../img/quizapp.jpg')} alt=""/>
					<form onSubmit={this.preventDefault.bind(this)} >
						<div className="vertical-align">
							<input placeholder={this.state.particapationType1} value={this.state.credential1} onChange={this.handelCredential1Change.bind(this)} className='credential_1' required type={this.state.inputType}/>
							<input placeholder={this.state.particapationType2} value={this.state.credential2} onChange={this.handelCredential2Change.bind(this)} className='credential_2' required type="text"/>
							<button onClick= {this.Submit.bind(this)} className = 'submit_form'>Submit</button>
						</div>
					</form>
				</div>
			</div>
			<div className="col-9 section-background">
			</div>
		</div>
    );
  }
}

export default Login;







/*response casesdekh le
1 - { success : false , message : "Whatever error occured - Invalid Credentials / User already logged in / Invalid Method / Invalid Arguments" }
2 - { success : true , starting_time : null or timestamp , ending_time : null or timestamp }
jab tu  call krega to tujhe current timestamp mil jaega usko use krke check ke ending_time is less than current time or not*/

// chirgjin@gmail.com
// 9212040857